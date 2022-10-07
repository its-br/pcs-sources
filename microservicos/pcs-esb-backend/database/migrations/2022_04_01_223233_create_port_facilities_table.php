<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\PortFacilityType;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('port_facilities', function (Blueprint $table) {
            $table->id();
            $table->string('cnpj')->unique();
            $table->string('email');
            $table->string('phone');
            $table->foreignIdFor(PortFacilityType::class)->nullable();
            $table->string('address');
            $table->string('state');
            $table->string('city');
            $table->string('postal_code');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('port_facilities');
    }
};
