<?php

namespace App\Http\Controllers;

use App\Helpers\PCS;
use App\Models\Voyage;
use App\Models\TransportCall;
use App\Models\OtherMaritimeAgency;
use App\Models\VoyageAcceptance;
use App\Models\MaritimeAgent;
use App\Models\PortFacility;
use App\Models\VoyageStatus;
use App\Models\VesselOperatorResponse;
use App\Models\EventPlanningStatus;
use Illuminate\Http\Request;
use App\Http\Resources\VoyageResource;
use App\Http\Resources\VoyageAcceptanceResource;
use App\Http\Resources\VoyageStatusResource;
use App\Models\PortFacilityType;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;


class VoyageController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->hasHeader('Authorization')){
            $jwtAuth = PCS::parseJwt($request->header('Authorization'));
            if ( $jwtAuth->profile == 'PortFacilities' ){
                return VoyageResource::collection(Voyage::whereRelation('transport_calls', 'port_facility_cnpj', $jwtAuth->cnpj)->get());
            }
        }
        return VoyageResource::collection(Voyage::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->hasHeader('Authorization')){
            $jwtAuth = PCS::parseJwt($request->header('Authorization'));
        }
        if ( $jwtAuth->profile !== 'MaritimeAgent' || MaritimeAgent::where('cnpj', $jwtAuth->cnpj)->count() < 1){
            return response()->json('Maritime Agent not found!', 404);
        }
        $maritimeAgent = MaritimeAgent::where('cnpj', $jwtAuth->cnpj)->first();

        $voyage = new Voyage;

        $voyage->maritime_agent_id = $maritimeAgent->id;
        $voyage->list_provider = $request->carrierDetails['listProvider'];
        $voyage->carrier_code = $request->carrierDetails['carrierCode'];
        $voyage->carrier_voyage_number = $request->carrierVoyageDetails['carrierVoyageNumber'];
        $voyage->vessel_imo = $request->carrierVoyageDetails['vesselIMO'];
        $voyage->un_location_code = $request->carrierVoyageDetails['UNLocationCode'];
        $voyage->callback_url = $request->maritimeAgencyCallBack['callBackURL'];
        $voyage->start_date_iso = $request->maritimeAgencyCallBack['startDate'];
        $voyage->range_date_iso = $request->maritimeAgencyCallBack['rangeDate'];

        $voyage->save();

        foreach ($request->transportCall as $request_transport_call) {
            $transport_call = new TransportCall;
            $transport_call->transport_call_id = $request_transport_call['transportCallID'];
            $transport_call->port_facility_type_dcsa_code = $request_transport_call['portFacilityTypeDcsaCode'];
            $transport_call->port_facility_cnpj = $request_transport_call['portFacilityCnpj'];
            $transport_call->mooring_operator_cnpj = $request_transport_call['mooringOperatorCnpj'];
            $transport_call->tugboat_company_cnpj = $request_transport_call['tugboatCompanyCnpj'];
            $voyage->transport_calls()->save($transport_call);
            
            $event_planning_status = new EventPlanningStatus;

            $event_planning_status->transport_call_id = $request_transport_call['transportCallID'];
            $event_planning_status->berthing_status_code = 'B000';
            $event_planning_status->pilot_boarding_place_status_code = 'P000';
            $event_planning_status->start_operation_status_code = 'S000';
            $event_planning_status->completion_operation_status_code = 'C000';
            $event_planning_status->unberthing_status_code = 'D000';
            $voyage->event_planning_status()->save($event_planning_status);

            // Adiciona um voyage-acceptance default para cada transportcall (status code = T000)
            $voyage_acceptance = new VoyageAcceptance;

            $voyage_acceptance->cnpj = $transport_call->port_facility_cnpj;
            $voyage_acceptance->voyage_id = $voyage->id;
            $voyage_acceptance->transport_call_id = $transport_call->transport_call_id;
            $voyage_acceptance->acceptance = null;
            $voyage_acceptance->status_code = 'T000';
            $voyage_acceptance->responsability_code = null;
    
            $voyage_acceptance->save();
        }
        
        foreach ($request->otherMaritimeAgency as $request_other_maritime_agency) {
            $other_maritime_agency = new OtherMaritimeAgency;
            $other_maritime_agency->maritime_agent_cnpj = $request_other_maritime_agency['maritimeAgencyCnpj'];
            $other_maritime_agency->responsability_code = $request_other_maritime_agency['responsabilityCode'];
            $voyage->other_maritime_agency()->save($other_maritime_agency);
            // TODO: criar um voyage-acceptance default para cada otherMaritimeAgent (status code = T001)
            $voyage_acceptance = new VoyageAcceptance;
            $voyage_acceptance->cnpj = $request_other_maritime_agency['maritimeAgencyCnpj'];
            $voyage_acceptance->voyage_id = $voyage->id;
            $voyage_acceptance->transport_call_id = null;
            $voyage_acceptance->acceptance = null;
            $voyage_acceptance->status_code = 'A001';
            $voyage_acceptance->responsability_code = $request_other_maritime_agency['responsabilityCode'];
            $voyage_acceptance->save();
        }

        $voyage_status = new VoyageStatus;

        $voyage_status->status_code_imo = 'I000';
        $voyage_status->status_code_public_systems = 'M000';
        $voyage_status->status_code_agent = (isset($other_maritime_agency)) ? 'A001' : 'A000';
        $voyage_status->status_code_terminal = 'T000';
        $voyage_status->status_code_subscription = 'U000';
        $voyage->voyage_status()->save($voyage_status);
        
        return response()->json([
            'receiptID' => str_pad($voyage->id, 20, '0', STR_PAD_LEFT)
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Voyage  $voyage
     * @return \Illuminate\Http\Response
     */
    public function show(Voyage $voyage)
    {
        return new VoyageResource(Voyage::findOrFail($voyage->id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Voyage  $voyage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Voyage $voyage)
    {
        if (isset($request->carrierDetails['listProvider'])) $voyage->list_provider = $request->carrierDetails['listProvider'];
        if (isset($request->carrierDetails['carrierCode'])) $voyage->carrier_code = $request->carrierDetails['carrierCode'];
        if (isset($request->carrierVoyageDetails['carrierVoyageNumber'])) $voyage->carrier_voyage_number = $request->carrierVoyageDetails['carrierVoyageNumber'];
        if (isset($request->carrierVoyageDetails['vesselIMO'])) $voyage->vessel_imo = $request->carrierVoyageDetails['vesselIMO'];
        if (isset($request->carrierVoyageDetails['UNLocationCode'])) $voyage->un_location_code = $request->carrierVoyageDetails['UNLocationCode'];
        if (isset($request->maritimeAgencyCallBack['callBackURL'])) $voyage->callback_url = $request->maritimeAgencyCallBack['callBackURL'];
        if (isset($request->maritimeAgencyCallBack['startDate'])) $voyage->start_date_iso = $request->maritimeAgencyCallBack['startDate'];
        if (isset($request->maritimeAgencyCallBack['rangeDate'])) $voyage->range_date_iso = $request->maritimeAgencyCallBack['rangeDate'];

        $voyage->save();

        if ($request->has('transportCall')) {
            $voyage->transport_calls()->delete();
            foreach ($request->transportCall as $request_transport_call) {
                $transport_call = new TransportCall;
                $transport_call->port_facility_type_dcsa_code = $request_transport_call['portFacilityTypeDcsaCode'];
                $transport_call->port_facility_cnpj = $request_transport_call['portFacilityCnpj'];
                $transport_call->mooring_operator_cnpj = $request_transport_call['mooringOperatorCnpj'];
                $transport_call->tugboat_company_cnpj = $request_transport_call['tugboatCompanyCnpj'];
                $voyage->transport_calls()->save($transport_call);
            }
        }

        if ($request->has('otherMaritimeAgency')) {
            $voyage->other_maritime_agency()->delete();
            foreach ($request->otherMaritimeAgency as $request_other_maritime_agency) {
                $other_maritime_agency = new OtherMaritimeAgency;
                $other_maritime_agency->maritime_agent_cnpj = $request_other_maritime_agency['maritimeAgencyCnpj'];
                $other_maritime_agency->responsability_code = $request_other_maritime_agency['responsabilityCode'];
                $voyage->other_maritime_agency()->save($other_maritime_agency);
            }
        }

        if (isset($other_maritime_agency) && ($voyage->voyage_status()->status_code_agent == 'A000')) {
            $voyage->voyage_status()->status_code_agent = 'A001';
            $voyage->voyage_status()->save();
        }

        return response()->json('', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Voyage  $voyage
     * @return \Illuminate\Http\Response
     */
    public function destroy(Voyage $voyage)
    {
        $voyage->transport_calls()->delete();
        $voyage->other_maritime_agency()->delete();
        $voyage->vessel_operator_response()->delete();
        $voyage->voyage_acceptances()->delete();
        $voyage->voyage_status()->delete();
        $voyage->event_plannings()->delete();
        $voyage->event_planning_status()->delete();
        $voyage->delete();

        return response()->json('', 204);
    }

    /**
     * Display a listing of the acceptance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index_acceptance(Request $request)
    {
        try {
            if ($request->hasHeader('Authorization')){
                $jwtAuth = PCS::parseJwt($request->header('Authorization'));
            }
            $jwtPCSAuth = PCS::parseJwt($request->header('PCSAuthorization'));
        } catch (\Throwable $e) {
            Log::error([$e]);
            return response("Authentication Error", 500);
        }
        if ($jwtAuth->profile == 'MaritimeAgent' || $jwtAuth->profile == 'PortAuthority'){
            return VoyageAcceptanceResource::collection(VoyageAcceptance::get());
        }else{
            return VoyageAcceptanceResource::collection(VoyageAcceptance::where('cnpj', $jwtPCSAuth->cnpj)->get());
        }
    }

    /**
     * Makes a receiptID on PCSvoyageID.
     *
     * @param  int|string  $id
     * @return void
     */
    private function turns_voyage($id)
    {
        $id = (int) $id; // "00000000000000000012" => 12
        $voyage_acceptances = VoyageAcceptance::where('voyage_id', $id)->get();

        $voyage_status = VoyageStatus::firstWhere('voyage_id', $id);

        // update voyage_status
        foreach ($voyage_acceptances as $voyage_acceptance) {
            if (null === $voyage_acceptance->transport_call_id){ 
                $maritime_agents = MaritimeAgent::where('cnpj', $voyage_acceptance->cnpj)->count();
    
                if ($maritime_agents > 0) {
                    if ($voyage_acceptance->acceptance == 'Accepted') {
                        $voyage_status->status_code_agent = 'A003';
                    } else if ($voyage_acceptance->acceptance == 'Refused') {
                        $voyage_status->status_code_agent = 'A002';
                    }
                }
            }else{
                $terminals = PortFacility::where('cnpj', $voyage_acceptance->cnpj)->whereHas('port_facility_type', function (Builder $query) {
                    $query->where('dcsa_code', 'POTE');
                })->count();
    
                if ($terminals > 0) {
                    if ($voyage_acceptance->acceptance == 'Accepted') {
                        $voyage_status->status_code_terminal = 'T002';
                    } else if ($voyage_acceptance->acceptance == 'Refused') {
                        $voyage_status->status_code_terminal = 'T001';
                    }
                }
            }
            $voyage_status->save();
        }

        $voyage = Voyage::find($id);

        if (($voyage_status->status_code_agent == 'A003') && ($voyage_status->status_code_terminal == 'T002')) {
            $voyage->id_method = 'PCSVoyageID';
        } else {
            $voyage->id_method = 'receiptID';
        }
        $voyage->save();
    }

    /**
     * Store a newly created acceptance in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_acceptance(Request $request)
    {
        $jwtPCSAuth = PCS::parseJWT($request->header('PCSAuthorization'));
        $jwtAuth = PCS::parseJWT($request->header('Authorization'));
        
        $voyage_id = $request->has('PCSVoyageID')? $request->PCSVoyageID : $request->receiptID;
        $voyage = Voyage::where('id', (int) $voyage_id)->first();
        if ($voyage == null){
            return response()->json('Voyage '. $voyage_id . ' not found!', 404);
        }
        // A API POST /voyage-acceptance sempre atualizará a aceitação criada no voyage creation, nunca cria uma nova 
        if (str_starts_with($request->statusCode, 'A00') && $request->transportCallID === null ){
            // MaritimeAgentSecondary
            if ( $jwtAuth->profile !== 'MaritimeAgentSecondary' || MaritimeAgent::where('cnpj', $jwtPCSAuth->cnpj)->count() < 1){
                return response()->json('Maritime Agent Secondary not found!', 404);
            }
            $voyage_acceptance = VoyageAcceptance::where('cnpj', $jwtPCSAuth->cnpj)->where('voyage_id', (int) $voyage_id)->first();
            if (null == $voyage_acceptance){
                return response()->json('Voyage Acceptance not found', 404);
            }
            // Update Acceptance
            if ($request->has('cnpj')) $voyage_acceptance->cnpj = $request->cnpj;
            if ($request->has('acceptance')) $voyage_acceptance->acceptance = $request->acceptance;
            if ($request->has('statusCode')) $voyage_acceptance->status_code = $request->statusCode;
            if ($request->has('transportCallID')) $voyage_acceptance->transport_call_id = $request->transportCallID;
            if ($request->has('responsabilityCode')) $voyage_acceptance->responsability_code = $request->responsabilityCode;
            $voyage_acceptance->save();
        } else if (str_starts_with($request->statusCode, 'T00') && $request->transportCallID !== null ){
            // PortFacilities 
            if ( $jwtAuth->profile !== 'PortFacilities' || PortFacility::where('cnpj', $jwtPCSAuth->cnpj)->count() < 1){
                return response()->json('Maritime Agent Secondary not found!', 404);
            }
            $voyage_acceptance = VoyageAcceptance::where('cnpj', $jwtPCSAuth->cnpj)->where('transport_call_id', $request->transportCallID)->where('voyage_id', (int) $voyage_id)->first();
            if (null == $voyage_acceptance){
                return response()->json('Voyage Acceptance not found', 404);
            }
            if ($request->has('cnpj')) $voyage_acceptance->cnpj = $request->cnpj;
            if ($request->has('acceptance')) $voyage_acceptance->acceptance = $request->acceptance;
            if ($request->has('statusCode')) $voyage_acceptance->status_code = $request->statusCode;
            if ($request->has('transportCallID')) $voyage_acceptance->transport_call_id = $request->transportCallID;
            $voyage_acceptance->save();
        }else{
            return response()->json('Inconsistency with Voyage Acceptance !', 409);
        }

        $this->turns_voyage($voyage_id);

        return response()->json('', 200);
    }

    /**
     * Update the specified acceptance in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Voyage  $voyage
     * @return \Illuminate\Http\Response
     */
    public function update_acceptance(Request $request, Voyage $voyage)
    {
        $jwtPCSAuth = PCS::parseJWT($request->header('PCSAuthorization'));

        $voyage_acceptances = VoyageAcceptance::where('cnpj', $jwtPCSAuth->cnpj)->where('voyage_id', $voyage->id)->get();

        foreach ($voyage_acceptances as $voyage_acceptance) {
            if ($request->has('acceptance')) $voyage_acceptance->acceptance = $request->acceptance;
            if ($request->has('responsabilityCode')) $voyage_acceptance->responsability_code = $request->responsabilityCode;
            $voyage_acceptance->save();
        }

        $this->turns_voyage($voyage->id);

        return response()->json('', 200);
    }

    /**
     * Display the voyage status.
     *
     * @param  \App\Models\Voyage  $voyage
     * @return \Illuminate\Http\Response
     */
    public function show_status(Voyage $voyage)
    {
        return new VoyageStatusResource(VoyageStatus::firstWhere('voyage_id', $voyage->id));
    }

    /** 
     * Store a newly created vessel operator response in storage.
     *  
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_vessel_operator_response(Request $request)
    {
        try {
            if ($request->has('voyage_id') && $request->voyage_id){
                $voyage_id = $request->voyage_id;
            }else{
                $content = $request->getContent();
                preg_match('/[a-zA-Z0-9]{20}/m', $content, $matches);
                $voyage_id = $matches[0];
            }
            $UNNames = ['BRSSZ' => 'Santos', 'BRPNG' => 'Paranagua', 'BRITJ' => 'Itajai'];
            $voyage = Voyage::findOrFail($voyage_id);

            $vessel_operator_response = new VesselOperatorResponse;

            $vessel_operator_response->subscriptionID = Str::random(10);
            $vessel_operator_response->vesselOperatorCarrierCode = $voyage->carrier_code;
            $vessel_operator_response->vesselOperatorCarrierCodeListProvider = $voyage->list_provider;
            $vessel_operator_response->vesselPartnerCarrierCode = $voyage->carrier_code;
            $vessel_operator_response->vesselPartnerCarrierCodeListProvider = $voyage->list_provider;
            $vessel_operator_response->startDate = date('Y-m-d');
            $vessel_operator_response->rangeDate = 'P4W';
            $vessel_operator_response->carrierServiceCode = 'FE1';
            $vessel_operator_response->vesselIMOnumber = $voyage->vessel_imo;
            $vessel_operator_response->vesselName = $this->getVesselName($voyage->carrier_code, $voyage->vessel_imo);
            $vessel_operator_response->carrierVoyageNumber = $voyage->carrier_voyage_number;
            $vessel_operator_response->UNLocationCode = $voyage->un_location_code;
            $vessel_operator_response->UNLocationName = isset($UNNames[$voyage->un_location_code])?$UNNames[$voyage->un_location_code]:'Santos';
            $vessel_operator_response->transportCallNumber = 1;
            $vessel_operator_response->facilityTypeCode = 'POTE';
            $vessel_operator_response->facilityCode = 'AEAUHADT';
            $vessel_operator_response->otherFacility = 'Av. portuaria, n ' . rand(10, 1000) . ', centro';

            $voyage->vessel_operator_response()->save($vessel_operator_response);
        } catch (\Throwable $e) {
            Log::error($e);
        }
        return response()->json('', 201);
    }

    /**
     * Return a dynamic Vessel Name
     *  
     * @param string $carrierCode 
     * @param string $vesselIMO
     * 
     * @return string Vessel Name
     */
    private function getVesselName($carrierCode, $vesselIMO = null)
    {
        try {
            $carriersCode = [
                'MSCU' => "MSC BARCELONA", 
                'SUDU' => "HAMBURG EXPRESS", 
                'MAEU' => "MAERSK AMAZON", 
                '11DX' => "CNC LION"
            ];
            $vesselsIMO = [
                '1234567' => 'BLACK PEARL',
                '9248162' => 'MAERSK YANGTZE',
                '9175808' => 'MAERSK ATLANTIC',
                '9342504' => 'MAERSK ANTARES',
                '9401776' => 'MSC ACAPULCO',
                '9467419' => 'MSC LAURENCE',
                '9286231' => 'MSC EVEREST',
                '9706279' => 'CNC BANGKOK',
                '9836660' => 'CNC MARS',
                '9836684' => 'CNC SATURN',
                '1801323' => 'RMS NAUTILUS'
            ];
            if ( null !== $vesselIMO && isset($vesselsIMO[$vesselIMO])){
                return $vesselsIMO[$vesselIMO];
            }else if ( null !== $carrierCode && isset($carriersCode[$carrierCode])){
                return $carriersCode[$carrierCode];
            }
        } catch (\Throwable $e) {
        }
        $randomName = '';
        $vogais = ['A','E','I','O','U'];  
        $consoants = ['B','C','D','F','G','H','J','K','L','M','N','P','R','S','T','V','W','X','Y','Z'];
        for ($i = 1; $i <= 4; $i++){
            $randomName .= $consoants[rand(0,19)];
            $randomName .= $vogais[rand(0,4)];
        }
        return "RMS " . $randomName;
    }
}
