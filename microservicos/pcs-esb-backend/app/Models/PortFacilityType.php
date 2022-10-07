<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PortFacilityType extends Model
{
    use HasFactory;

    use SoftDeletes;

    /**
     * Get the port facilities for the port facility type.
     */
    public function port_facilities()
    {
        return $this->hasMany(PortFacility::class);
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'dcsa_code';
    }
}
