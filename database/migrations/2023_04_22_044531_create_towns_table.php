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
        Schema::create('towns', function (Blueprint $table) {
            $table->char('code', 4)->primary()->comment('鄉鎮市區編號');
            $table->char('name', 5)->comment('鄉鎮市區名稱');
            $table->char('county_code', 2)->comment('縣市編號');
            $table->foreign('county_code')->references('code')->on('counties');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('towns', function (Blueprint $table) {
            $table->dropForeign(['county_code']);
        });
        Schema::dropIfExists('towns');
    }
};
