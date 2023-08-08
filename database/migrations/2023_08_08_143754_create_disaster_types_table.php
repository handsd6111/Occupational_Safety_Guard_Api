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
        Schema::create('disaster_types', function (Blueprint $table) {
            $table->char('code', 4)->primary()->comment('災害類型編號');
            $table->char('name', 35)->comment('災害類型名稱');
            // $table->id();
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disaster_types');
    }
};
