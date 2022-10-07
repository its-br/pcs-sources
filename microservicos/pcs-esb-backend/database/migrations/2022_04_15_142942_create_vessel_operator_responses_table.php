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
        Schema::create('vessel_operator_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Voyage::class);
            $table->string('subscriptionID');
            $table->string('vesselOperatorCarrierCode');
            $table->string('vesselOperatorCarrierCodeListProvider');
            $table->string('vesselPartnerCarrierCode');
            $table->string('vesselPartnerCarrierCodeListProvider');
            $table->string('startDate');
            $table->string('rangeDate');
            $table->string('carrierServiceCode');
            $table->string('vesselIMOnumber');
            $table->string('vesselName');
            $table->string('carrierVoyageNumber');
            $table->string('UNLocationCode');
            $table->string('UNLocationName');
            $table->string('transportCallNumber');
            $table->string('facilityTypeCode');
            $table->string('facilityCode');
            $table->string('otherFacility');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
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
        Schema::dropIfExists('vessel_operator_responses');
    }
};
