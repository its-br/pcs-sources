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
        Schema::create('voyage_statuses', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Voyage::class);
            $table->string('status_code_imo');
            $table->string('status_code_public_systems');
            $table->string('status_code_agent');
            $table->string('status_code_terminal');
            $table->string('status_code_subscription');
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
        Schema::dropIfExists('voyage_statuses');
    }
};
