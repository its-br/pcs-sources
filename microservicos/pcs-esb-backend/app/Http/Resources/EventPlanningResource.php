<?php

namespace App\Http\Resources;

use DateTime;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;

class EventPlanningResource extends JsonResource
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
            'eventCreatedDateTime' => (new DateTime($this->event_created_date_time))->format('Y-m-d\TH:i:s\Z'),
            'eventTime' => (new DateTime($this->event_time))->format('Y-m-d\TH:i:s\Z'),
            'eventType' => $this->event_type,
            'transportEventTypeCode' => $this->transport_event_type_code,
            'operationsEventTypeCode' => $this->operations_event_type_code,
            'eventClassifierCode' => $this->event_classifier_code,
        ];
    }
}
