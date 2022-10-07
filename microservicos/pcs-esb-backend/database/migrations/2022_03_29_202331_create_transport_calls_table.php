<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Voyage;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transport_calls', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Voyage::class);
            $table->string('transport_call_id');
            $table->string('port_facility_type_dcsa_code');
            $table->string('port_facility_cnpj');
            $table->string('mooring_operator_cnpj');
            $table->string('tugboat_company_cnpj');
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
        Schema::dropIfExists('transport_calls');
    }
};
