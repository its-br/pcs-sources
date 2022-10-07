<?php

use App\Models\MaritimeAgent;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('voyages', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(MaritimeAgent::class);
            $table->string('list_provider');
            $table->string('carrier_code');
            $table->string('carrier_voyage_number');
            $table->string('vessel_imo');
            $table->string('un_location_code');
            $table->string('callback_url');
            $table->string('start_date_iso');
            $table->string('range_date_iso');
            $table->string('id_method')->default('receiptID');
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
        Schema::dropIfExists('voyages');
    }
};
