<?php

namespace App\Http\Controllers;

use App\Models\MaritimeAgent;
use App\Models\UserAgent;
use Illuminate\Http\Request;
use App\Http\Resources\MaritimeAgentResource;

class MaritimeAgentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return MaritimeAgentResource::collection(MaritimeAgent::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $maritime_agent = new MaritimeAgent;

        $maritime_agent->cnpj = $request->cnpj;
        $maritime_agent->email = $request->email;
        $maritime_agent->phone = $request->phone;
        $maritime_agent->address = $request->address['address'];
        $maritime_agent->state = $request->address['state'];
        $maritime_agent->city = $request->address['city'];
        $maritime_agent->postal_code = $request->address['postalCode'];

        $maritime_agent->save();

        return response('', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MaritimeAgent  $maritimeAgent
     * @return \Illuminate\Http\Response
     */
    public function show(MaritimeAgent $maritimeAgent)
    {
        return new MaritimeAgentResource(MaritimeAgent::findOrFail($maritimeAgent->id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MaritimeAgent  $maritimeAgent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MaritimeAgent $maritimeAgent)
    {
        if ($request->has('cnpj')) $maritimeAgent->cnpj = $request->cnpj;
        if ($request->has('email')) $maritimeAgent->email = $request->email;
        if ($request->has('phone')) $maritimeAgent->phone = $request->phone;
        if (isset($request->address['address'])) $maritimeAgent->address = $request->address['address'];
        if (isset($request->address['state'])) $maritimeAgent->state = $request->address['state'];
        if (isset($request->address['city'])) $maritimeAgent->city = $request->address['city'];
        if (isset($request->address['postalCode'])) $maritimeAgent->postal_code = $request->address['postalCode'];

        $maritimeAgent->save();

        return response('', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MaritimeAgent  $maritimeAgent
     * @return \Illuminate\Http\Response
     */
    public function destroy(MaritimeAgent $maritimeAgent)
    {
        $maritimeAgent->delete();

        return response('', 204);
    }

    /**
     * Link user agent to maritime agent.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_user_agent(Request $request)
    {
        $maritime_agent = MaritimeAgent::firstWhere('cnpj', $request->cnpj);

        $user_agent = UserAgent::firstWhere('cnpj', $request->cnpjUserAgent);

        $maritime_agent->user_agents()->attach($user_agent->id);

        $maritime_agent->save();

        return response('', 201);
    }
}
