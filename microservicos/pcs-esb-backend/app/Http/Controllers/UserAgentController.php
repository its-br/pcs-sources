<?php

namespace App\Http\Controllers;

use App\Models\UserAgent;
use Illuminate\Http\Request;
use App\Http\Resources\UserAgentResource;

class UserAgentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return UserAgentResource::collection(UserAgent::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user_agent = new UserAgent;

        $user_agent->cnpj = $request->cnpj;
        $user_agent->email = $request->email;
        $user_agent->phone = $request->phone;
        $user_agent->address = $request->address['address'];
        $user_agent->state = $request->address['state'];
        $user_agent->city = $request->address['city'];
        $user_agent->postal_code = $request->address['postalCode'];

        $user_agent->save();

        return response('', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserAgent  $userAgent
     * @return \Illuminate\Http\Response
     */
    public function show(UserAgent $userAgent)
    {
        return new UserAgentResource(UserAgent::findOrFail($userAgent->id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserAgent  $userAgent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserAgent $userAgent)
    {
        if ($request->has('cnpj')) $userAgent->cnpj = $request->cnpj;
        if ($request->has('email')) $userAgent->email = $request->email;
        if ($request->has('phone')) $userAgent->phone = $request->phone;
        if (isset($request->address['address'])) $userAgent->address = $request->address['address'];
        if (isset($request->address['state'])) $userAgent->state = $request->address['state'];
        if (isset($request->address['city'])) $userAgent->city = $request->address['city'];
        if (isset($request->address['postalCode'])) $userAgent->postal_code = $request->address['postalCode'];

        $userAgent->save();

        return response('', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserAgent  $userAgent
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserAgent $userAgent)
    {
        $userAgent->delete();

        return response('', 204);
    }
}
