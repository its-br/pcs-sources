<?php

namespace App\Http\Resources;

use App\Models\OtherMaritimeAgency;
use Illuminate\Http\Resources\Json\JsonResource;

class OtherMaritimeAgencyResource extends JsonResource
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
            'maritimeAgencyCnpj' => $this->maritime_agent_cnpj,
            'responsabilityCode' => $this->responsability_code,
        ];
    }

}
