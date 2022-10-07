<?php

namespace App\Http\Resources;

use App\Models\TransportCall;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;

class VoyageAcceptanceResource extends JsonResource
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
            $this->voyage->id_method => str_pad($this->voyage_id, 20, '0', STR_PAD_LEFT),
            'cnpj' => $this->cnpj,
            'acceptance' => $this->acceptance,
            'transportCallID' => $this->transport_call_id,
            'statusCode' => $this->status_code,
            'responsabilityCode' => $this->responsability_code,
        ];
        if ($response['transportCallID'] == null) { unset($response['transportCallID']); }
        if ($response['responsabilityCode'] == null) { unset($response['responsabilityCode']); }
        return $response;
    }
}
