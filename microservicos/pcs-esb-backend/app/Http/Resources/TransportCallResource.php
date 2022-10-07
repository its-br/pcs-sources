<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransportCallResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'transportCallID' => $this->transport_call_id,
            'portFacilityTypeDcsaCode' => $this->port_facility_type_dcsa_code,
            'portFacilityCnpj' => $this->port_facility_cnpj,
            'mooringOperatorCnpj' => $this->mooring_operator_cnpj,
            'tugboatCompanyCnpj' => $this->tugboat_company_cnpj,
        ];
    }
}
