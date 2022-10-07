<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MooringOperator extends Model
{
    use HasFactory;

    use SoftDeletes;

    /**
     * The user agents that belong to the mooring operator.
     */
    public function user_agents()
    {
        return $this->belongsToMany(UserAgent::class);
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
