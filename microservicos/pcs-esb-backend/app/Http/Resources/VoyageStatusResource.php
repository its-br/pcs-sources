<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VoyageStatusResource extends JsonResource
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
            'statusCodeIMO' => $this->status_code_imo,
            'statusCodePublicSystems' => $this->status_code_public_systems,
            'statusCodeAgent' => $this->status_code_agent,
            'statusCodeTerminal' => $this->status_code_terminal,
            'statusCodeSubscription' => $this->status_code_subscription,
        ];

        if ($this->voyage->id_method == 'PCSVoyageID') {
            $response['PCSVoyageID'] = str_pad($this->voyage_id, 20, '0', STR_PAD_LEFT);
        }

        return $response;
    }
}
