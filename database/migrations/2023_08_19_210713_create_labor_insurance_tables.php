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
        Schema::create('labor_identities', function (Blueprint $table) {
            $table->smallInteger('id')->primary()->comment('身分編號');
            $table->string('name', 10)->comment('身份名稱');
        });

        Schema::create('labor_extra_identities', function (Blueprint $table) {
            $table->smallInteger('id')->primary()->comment('額外身分編號');
            $table->string('name', 15)->comment('額外身份名稱');
            $table->smallInteger('li_id')->comment('身份編號');
            $table->foreign('li_id')->references('id')->on('labor_identities');
        });

        Schema::create('labor_subsidies', function (Blueprint $table) {
            $table->smallInteger('id')->primary()->comment('補助項目編號');
            $table->string('name', 10)->comment('補助項目名稱');
        });

        Schema::create('labor_extra_identity_subsidies', function (Blueprint $table) {
            $table->smallIncrements('id')->comment('額外身份對應補助項目編號');
            $table->smallInteger('lei_id')->comment('身份編號');
            $table->smallInteger('ls_id')->comment('補助項目編號');
            $table->foreign('lei_id')->references('id')->on('labor_extra_identities');
            $table->foreign('ls_id')->references('id')->on('labor_subsidies');
        });

        Schema::create('labor_qualifies', function (Blueprint $table) {
            $table->smallInteger('id')->primary()->comment('資格編號');
            $table->string('name', 35)->comment('資格名稱');
            $table->string('content', 2048)->comment('資格內容');
            $table->smallInteger('ls_id')->comment('補助項目編號');
            $table->foreign('ls_id')->references('id')->on('labor_subsidies');
        });

        Schema::create('labor_files', function (Blueprint $table) {
            $table->smallInteger('id')->primary()->comment('文件編號');
            $table->string('name', 512)->comment('文件名稱');
            // $table->string('url', 200)->comment('文件超連結');
        });

        Schema::create('labor_qualify_files', function (Blueprint $table) {
            $table->smallIncrements('id')->comment('資格對應文件編號');
            $table->smallInteger('lq_id')->comment('資格編號編號');
            $table->foreign('lq_id')->references('id')->on('labor_qualifies');
            $table->smallInteger('lf_id')->comment('文件編號');
            $table->foreign('lf_id')->references('id')->on('labor_files');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('labor_qualify_files', function (Blueprint $table) {
            $table->dropForeign(['lq_id']);
            $table->dropForeign(['lf_id']);
        });
        Schema::dropIfExists('labor_qualify_files');
        
        Schema::dropIfExists('labor_files');

        Schema::table('labor_qualifies', function (Blueprint $table) {
            $table->dropForeign(['ls_id']);
        });
        Schema::dropIfExists('labor_qualifies');

        Schema::table('labor_extra_identity_subsidies', function (Blueprint $table) {
            $table->dropForeign(['lei_id']);
            $table->dropForeign(['ls_id']);
        });
        Schema::dropIfExists('labor_extra_identity_subsidies');

        Schema::dropIfExists('labor_subsidies');

        Schema::table('labor_extra_identities', function (Blueprint $table) {
            $table->dropForeign(['li_id']);
        });
        Schema::dropIfExists('labor_extra_identities');
        Schema::dropIfExists('labor_identities');
    }
};