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
        Schema::create('event_planning_statuses', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Voyage::class);
            $table->string('transport_call_id');
            $table->string('berthing_status_code');
            $table->string('pilot_boarding_place_status_code');
            $table->string('start_operation_status_code');
            $table->string('completion_operation_status_code');
            $table->string('unberthing_status_code');
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
        Schema::dropIfExists('event_planning_statuses');
    }
};
