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
        Schema::create('refresh_tokens', function (Blueprint $table) {
            $table->string('id', 50)->primary()->comment('Token');
            $table->integer('user_id')->unsigned()->comment('使用者編號');
            $table->dateTime('expired_time')->comment('Token的過期時間');
            $table->foreign('user_id')->references('id')->on('users');
            // $table->id();
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('refresh_tokens', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists('refresh_tokens');
    }
};
