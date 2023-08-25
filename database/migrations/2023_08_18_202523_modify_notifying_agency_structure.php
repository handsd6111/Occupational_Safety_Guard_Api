<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('jurisdiction_regions', function (Blueprint $table) {
            $table->dropForeign(['na_id']);
        });

        Schema::table('jurisdiction_regions', function (Blueprint $table) {
            $table->dropColumn(['na_id']);
        });

        Schema::create('notifying_agency_regions', function (Blueprint $table) {
            $table->smallIncrements('id')->comment('機關對應管轄區編號');
            $table->smallInteger('na_id')->unsigned()->comment('通報機關編號');
            $table->smallInteger('jr_id')->unsigned()->comment('管轄區編號');
            $table->foreign('na_id')->references('id')->on('notifying_agencies');
            $table->foreign('jr_id')->references('id')->on('jurisdiction_regions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::table('notifying_agency_regions', function (Blueprint $table) {
            $table->dropForeign(['na_id']);
            $table->dropForeign(['jr_id']);
        });
        Schema::dropIfExists('notifying_agency_regions');

        Schema::table('jurisdiction_regions', function (Blueprint $table) {
            $table->smallInteger('na_id')->comment('機關編號')->unsigned();
            $table->foreign('na_id')->references('id')->on('notifying_agencies');
        });
    }
};
