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
            $table->string('na_id', 15)->comment('機關代碼');
            $table->string('region', 8)->comment('地區');
            // $table->timestamps();
            $table->primary(['na_id', 'region']);
            $table->foreign('na_id')->references('id')->on('notifying_agencies');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jurisdiction_regions', function (Blueprint $table) {
            $table->dropForeign(['na_id']);
        });
        Schema::dropIfExists('jurisdiction_regions');
    }
};
