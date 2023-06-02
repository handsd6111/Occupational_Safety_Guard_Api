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
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id')->comment('使用者編號');
            $table->string('account',35)->comment('帳號');
            $table->string('name', 20)->comment('姓名');
            $table->string('email', 35)->comment('信箱');
            $table->string('password', 30)->comment('密碼');
            $table->boolean('enabled')->comment('是否啟用 true:啟用 false:禁用')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
