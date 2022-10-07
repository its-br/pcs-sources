<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TugboatCompanyResource extends JsonResource
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
            'cnpj' => $this->cnpj,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => [
                'address' => $this->address,
                'state' => $this->state,
                'city' => $this->city,
                'postalCode' => $this->postal_code,
            ],
        ];
    }
}
