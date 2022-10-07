<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PortFacility extends Model
{
    use HasFactory;

    use SoftDeletes;

    /**
     * The user agents that belong to the port facility.
     */
    public function user_agents()
    {
        return $this->belongsToMany(UserAgent::class);
    }

    /**
     * Get the port facility type that owns the port facility.
     */
    public function port_facility_type()
    {
        return $this->belongsTo(PortFacilityType::class);
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'cnpj';
    }
}
