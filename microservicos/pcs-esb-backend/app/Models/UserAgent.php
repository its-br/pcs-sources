<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserAgent extends Model
{
    use HasFactory;

    use SoftDeletes;

    /**
     * The maritime agents that belong to the user agent.
     */
    public function maritime_agents()
    {
        return $this->belongsToMany(MaritimeAgent::class);
    }

    /**
     * The mooring operators that belong to the user agent.
     */
    public function mooring_operators()
    {
        return $this->belongsToMany(MooringOperator::class);
    }

    /**
     * The port facilities that belong to the user agent.
     */
    public function port_facilities()
    {
        return $this->belongsToMany(PortFacility::class);
    }

    /**
     * The tugboat companies that belong to the user agent.
     */
    public function tugboat_companies()
    {
        return $this->belongsToMany(TugboatCompany::class);
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
