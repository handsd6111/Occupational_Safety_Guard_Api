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
        Schema::create('jurisdiction_regions', function (Blueprint $table) {
            $table->id()->comment('管轄區編號');
            $table->bigInteger('na_id')->unsigned()->comment('機關編號');
            $table->string('region')->comment('地區');
            $table->foreign('na_id')->references('id')->on('notifying_agencies');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jurisdiction_regions', function (Blueprint $table) {
            $table->dropForeign('na_id');
        });
        Schema::dropIfExists('jurisdiction_regions');
    }
};
