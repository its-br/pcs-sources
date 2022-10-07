<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VesselOperatorResponseResource extends JsonResource
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
            'subscriptionID' => $this->subscriptionID,
            'vesselOperatorCarrierCode' => $this->vesselOperatorCarrierCode,
            'vesselOperatorCarrierCodeListProvider' => $this->vesselOperatorCarrierCodeListProvider,
            'vesselPartnerCarrierCode' => $this->vesselPartnerCarrierCode,
            'vesselPartnerCarrierCodeListProvider' => $this->vesselPartnerCarrierCodeListProvider,
            'startDate' => $this->startDate,
            'rangeDate' => $this->rangeDate,
            'voyageGeneralStatus' => [
                'carrierServiceCode' => $this->carrierServiceCode,
                'vesselIMOnumber' => $this->vesselIMOnumber,
                'vesselName' => $this->vesselName,
                'carrierVoyageNumber' => $this->carrierVoyageNumber,
                'UNLocationCode' => $this->UNLocationCode,
                'UNLocationName' => $this->UNLocationName,
                'transportCallNumber' => $this->transportCallNumber,
                'facilityTypeCode' => $this->facilityTypeCode,
                'facilityCode' => $this->facilityCode,
                'otherFacility' => $this->otherFacility,
            ],
        ];
    }
}
