<?php

namespace App\Http\Controllers;

use App\Models\PortFacility;
use App\Models\PortFacilityType;
use App\Models\UserAgent;
use Illuminate\Http\Request;
use App\Http\Resources\PortFacilityResource;

class PortFacilityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return PortFacilityResource::collection(PortFacility::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $port_facility = new PortFacility;

        $port_facility->cnpj = $request->cnpj;
        $port_facility->email = $request->email;
        $port_facility->phone = $request->phone;
        $port_facility->address = $request->address['address'];
        $port_facility->state = $request->address['state'];
        $port_facility->city = $request->address['city'];
        $port_facility->postal_code = $request->address['postalCode'];

        $port_facility->save();

        $port_facility_type = PortFacilityType::firstWhere('dcsa_code', $request->typeDcsaCode);

        $port_facility->port_facility_type()->associate($port_facility_type);

        $port_facility->save();

        return response('', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PortFacility  $portFacility
     * @return \Illuminate\Http\Response
     */
    public function show(PortFacility $portFacility)
    {
        return new PortFacilityResource(PortFacility::findOrFail($portFacility->id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PortFacility  $portFacility
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PortFacility $portFacility)
    {
        if ($request->has('cnpj')) $portFacility->cnpj = $request->cnpj;
        if ($request->has('email')) $portFacility->email = $request->email;
        if ($request->has('phone')) $portFacility->phone = $request->phone;
        if (isset($request->address['address'])) $portFacility->address = $request->address['address'];
        if (isset($request->address['state'])) $portFacility->state = $request->address['state'];
        if (isset($request->address['city'])) $portFacility->city = $request->address['city'];
        if (isset($request->address['postalCode'])) $portFacility->postal_code = $request->address['postalCode'];

        $portFacility->save();

        if ($request->has('typeDcsaCode')) {
            $port_facility_type = PortFacilityType::firstWhere('dcsa_code', $request->typeDcsaCode);
            $portFacility->port_facility_type()->associate($port_facility_type);
            $portFacility->save();
        }

        return response('', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PortFacility  $portFacility
     * @return \Illuminate\Http\Response
     */
    public function destroy(PortFacility $portFacility)
    {
        $portFacility->delete();

        return response('', 204);
    }

    /**
     * Link user agent to port facility.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_user_agent(Request $request)
    {
        $port_facility = PortFacility::firstWhere('cnpj', $request->cnpj);

        $user_agent = UserAgent::firstWhere('cnpj', $request->cnpjUserAgent);

        $port_facility->user_agents()->attach($user_agent->id);

        $port_facility->save();

        return response('', 201);
    }
}
