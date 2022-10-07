<?php

namespace App\Http\Controllers;

use App\Models\MooringOperator;
use App\Models\UserAgent;
use Illuminate\Http\Request;
use App\Http\Resources\MooringOperatorResource;

class MooringOperatorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return MooringOperatorResource::collection(MooringOperator::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $mooring_operator = new MooringOperator;

        $mooring_operator->cnpj = $request->cnpj;
        $mooring_operator->email = $request->email;
        $mooring_operator->phone = $request->phone;
        $mooring_operator->address = $request->address['address'];
        $mooring_operator->state = $request->address['state'];
        $mooring_operator->city = $request->address['city'];
        $mooring_operator->postal_code = $request->address['postalCode'];

        $mooring_operator->save();

        return response('', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MooringOperator  $mooringOperator
     * @return \Illuminate\Http\Response
     */
    public function show(MooringOperator $mooringOperator)
    {
        return new MooringOperatorResource(MooringOperator::findOrFail($mooringOperator->id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MooringOperator  $mooringOperator
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MooringOperator $mooringOperator)
    {
        if ($request->has('cnpj')) $mooringOperator->cnpj = $request->cnpj;
        if ($request->has('email')) $mooringOperator->email = $request->email;
        if ($request->has('phone')) $mooringOperator->phone = $request->phone;
        if (isset($request->address['address'])) $mooringOperator->address = $request->address['address'];
        if (isset($request->address['state'])) $mooringOperator->state = $request->address['state'];
        if (isset($request->address['city'])) $mooringOperator->city = $request->address['city'];
        if (isset($request->address['postalCode'])) $mooringOperator->postal_code = $request->address['postalCode'];

        $mooringOperator->save();

        return response('', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MooringOperator  $mooringOperator
     * @return \Illuminate\Http\Response
     */
    public function destroy(MooringOperator $mooringOperator)
    {
        $mooringOperator->delete();

        return response('', 204);
    }

    /**
     * Link user agent to mooring operator.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_user_agent(Request $request)
    {
        $mooring_operator = MooringOperator::firstWhere('cnpj', $request->cnpj);

        $user_agent = UserAgent::firstWhere('cnpj', $request->cnpjUserAgent);

        $mooring_operator->user_agents()->attach($user_agent->id);

        $mooring_operator->save();

        return response('', 201);
    }
}
