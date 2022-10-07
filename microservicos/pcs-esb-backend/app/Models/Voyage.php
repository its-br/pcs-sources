<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Voyage extends Model
{
    use HasFactory;

    use SoftDeletes;

    /**
     * Get the transport calls for the voyage.
     */
    public function transport_calls()
    {
        return $this->hasMany(TransportCall::class);
    }

    /**
     * Get the other maritime agents for the voyage.
     */
    public function other_maritime_agency()
    {
        return $this->hasMany(OtherMaritimeAgency::class);
    }

    /**
     * Get the other maritime agents for the voyage.
     */
    public function maritime_agent()
    {
        return $this->belongsTo(MaritimeAgent::class);
    }

    /**
     * Get the acceptances for the voyage.
     */
    public function voyage_acceptances()
    {
        return $this->hasMany(VoyageAcceptance::class);
    }

    /**
     * Get the vessel operator response associated with the voyage.
     */
    public function vessel_operator_response()
    {
        return $this->hasOne(VesselOperatorResponse::class);
    }

    /**
     * Get the status associated with the voyage.
     */
    public function voyage_status()
    {
        return $this->hasOne(VoyageStatus::class);
    }

    /**
     * Get the event plannings for the voyage.
     */
    public function event_plannings()
    {
        return $this->hasMany(EventPlanning::class);
    }

    /**
     * Get the event planning status associated with the voyage.
     */
    public function event_planning_status()
    {
        return $this->hasOne(EventPlanningStatus::class);
    }
}
