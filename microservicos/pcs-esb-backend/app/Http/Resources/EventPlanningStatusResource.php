<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EventPlanningStatusResource extends JsonResource
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
            'berthingStatusCode' => $this->berthing_status_code,
            'pilotBoardingPlaceStatusCode' => $this->pilot_boarding_place_status_code,
            'startOperationStatusCode' => $this->start_operation_status_code,
            'completionOperationStatusCode' => $this->completion_operation_status_code,
            'unberthingStatusCode' => $this->unberthing_status_code,
        ];
    }
}
