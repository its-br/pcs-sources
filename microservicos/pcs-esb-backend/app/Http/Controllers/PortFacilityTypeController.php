<?php

namespace App\Http\Controllers;

use App\Models\PortFacilityType;
use Illuminate\Http\Request;
use App\Http\Resources\PortFacilityTypeResource;

class PortFacilityTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return PortFacilityTypeResource::collection(PortFacilityType::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $port_facility_type = new PortFacilityType;

        $port_facility_type->dcsa_code = $request->dcsaCode;
        $port_facility_type->name = $request->name;
        $port_facility_type->description = $request->description;

        $port_facility_type->save();

        return response('', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PortFacilityType  $portFacilityType
     * @return \Illuminate\Http\Response
     */
    public function show(PortFacilityType $portFacilityType)
    {
        return new PortFacilityTypeResource(PortFacilityType::findOrFail($portFacilityType->id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PortFacilityType  $portFacilityType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PortFacilityType $portFacilityType)
    {
        if ($request->has('dcsaCode')) $portFacilityType->dcsa_code = $request->dcsaCode;
        if ($request->has('name')) $portFacilityType->name = $request->name;
        if ($request->has('description')) $portFacilityType->description = $request->description;

        $portFacilityType->save();

        return response('', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PortFacilityType  $portFacilityType
     * @return \Illuminate\Http\Response
     */
    public function destroy(PortFacilityType $portFacilityType)
    {
        $portFacilityType->delete();

        return response('', 204);
    }
}
