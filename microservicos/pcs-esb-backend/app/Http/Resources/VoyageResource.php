<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\TransportCallResource;
use App\Http\Resources\OtherMaritimeAgencyResource;
use App\Http\Resources\VesselOperatorResponseResource;
use App\Http\Resources\EventPlanningStatusResource;

class VoyageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $response = [
            // PCSVoyageID or receiptID
            // $this->id_method => $this->id,
            $this->id_method => str_pad($this->id, 20, '0', STR_PAD_LEFT),
            'carrierDetails' => [
                'listProvider' => $this->list_provider,
                'carrierCode' => $this->carrier_code,
            ],
            'carrierVoyageDetails' => [
                'carrierVoyageNumber' => $this->carrier_voyage_number,
                'vesselIMO' => $this->vessel_imo,
                'UNLocationCode' => $this->un_location_code,
            ],
            'transportCall' => TransportCallResource::collection($this->transport_calls),
            'maritimeAgencyCnpj' => $this->maritime_agent->cnpj,
            'otherMaritimeAgency' => OtherMaritimeAgencyResource::collection($this->other_maritime_agency),
            'maritimeAgencyCallBack' => [
                'callBackURL' => $this->callback_url,
                'startDate' => $this->start_date_iso,
                'rangeDate' => $this->range_date_iso,
            ],
            'vesselOperatorResponse' => new VesselOperatorResponseResource($this->vessel_operator_response),
            'eventPlanningStatus' => new EventPlanningStatusResource($this->event_planning_status),
        ];
        return $response;
    }
}
