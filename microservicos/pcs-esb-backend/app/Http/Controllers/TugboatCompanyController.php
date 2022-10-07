<?php

namespace App\Http\Controllers;

use App\Models\TugboatCompany;
use App\Models\UserAgent;
use Illuminate\Http\Request;
use App\Http\Resources\TugboatCompanyResource;

class TugboatCompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return TugboatCompanyResource::collection(TugboatCompany::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tugboat_company = new TugboatCompany;

        $tugboat_company->cnpj = $request->cnpj;
        $tugboat_company->email = $request->email;
        $tugboat_company->phone = $request->phone;
        $tugboat_company->address = $request->address['address'];
        $tugboat_company->state = $request->address['state'];
        $tugboat_company->city = $request->address['city'];
        $tugboat_company->postal_code = $request->address['postalCode'];

        $tugboat_company->save();

        return response('', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TugboatCompany  $tugboatCompany
     * @return \Illuminate\Http\Response
     */
    public function show(TugboatCompany $tugboatCompany)
    {
        return new TugboatCompanyResource(TugboatCompany::findOrFail($tugboatCompany->id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TugboatCompany  $tugboatCompany
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TugboatCompany $tugboatCompany)
    {
        if ($request->has('cnpj')) $tugboatCompany->cnpj = $request->cnpj;
        if ($request->has('email')) $tugboatCompany->email = $request->email;
        if ($request->has('phone')) $tugboatCompany->phone = $request->phone;
        if (isset($request->address['address'])) $tugboatCompany->address = $request->address['address'];
        if (isset($request->address['state'])) $tugboatCompany->state = $request->address['state'];
        if (isset($request->address['city'])) $tugboatCompany->city = $request->address['city'];
        if (isset($request->address['postalCode'])) $tugboatCompany->postal_code = $request->address['postalCode'];

        $tugboatCompany->save();

        return response('', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TugboatCompany  $tugboatCompany
     * @return \Illuminate\Http\Response
     */
    public function destroy(TugboatCompany $tugboatCompany)
    {
        $tugboatCompany->delete();

        return response('', 204);
    }

    /**
     * Link user agent to tugboat company.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_user_agent(Request $request)
    {
        $tugboat_company = TugboatCompany::firstWhere('cnpj', $request->cnpj);

        $user_agent = UserAgent::firstWhere('cnpj', $request->cnpjUserAgent);

        $tugboat_company->user_agents()->attach($user_agent->id);

        $tugboat_company->save();

        return response('', 201);
    }
}
