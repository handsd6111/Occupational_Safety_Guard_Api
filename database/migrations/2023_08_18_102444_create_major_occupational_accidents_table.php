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
        Schema::create('major_occupational_accidents', function (Blueprint $table) {
            $table->increments('id')->comment('重大職災編號');
            $table->string('business_unit', 75)->comment('事業單位');
            $table->string('detail_of_industry', 75)->comment('詳細行業別');
            $table->date('occurrence_date')->comment('發生日期');
            $table->smallInteger('number_of_victims')->comment('罹災人數');
            $table->string('project_name', 150)->comment('工程名稱');
            $table->string('accident_address', 150)->comment('罹災地址');
            $table->string('accident_location', 150)->comment('場所(罹災處)');
            $table->string('business_owner', 150)->comment('業主');
            $table->smallInteger('notifying_agency')->unsigned()->comment('勞動檢查機構');
            $table->foreign('notifying_agency')->references('id')->on('notifying_agencies');
            $table->char('industry', 2)->comment('行業別');
            $table->foreign('industry')->references('code')->on('industries');
            $table->char('accident_type', 5)->comment('災害類型');
            $table->foreign('accident_type')->references('code')->on('accident_types');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('major_occupational_accidents', function (Blueprint $table) {
            $table->dropForeign(['notifying_agency']);
            $table->dropForeign(['industry']);
            $table->dropForeign(['accident_type']);
        });
        Schema::dropIfExists('major_occupational_accidents');
    }
};
