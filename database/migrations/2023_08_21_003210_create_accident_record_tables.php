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
        Schema::create('accident_records', function (Blueprint $table) {
            $table->id()->comment('職災紀錄編號');
            $table->char('business_industry_code', 2)->comment('')->nullable()->comment('公司行業別');
            $table->string('business_name', 50)->nullable()->comment('公司名稱');
            $table->integer('number_of_labor')->nullable()->comment('勞工人數');
            $table->string('business_owner', 30)->nullable()->comment('代表人姓名');
            $table->string('business_address', 100)->nullable()->comment('公司地址');
            $table->string('business_phone', 20)->nullable()->comment('公司電話');
            $table->string('contract_relationship_description', 1024)->nullable()->comment('承攬關係描述');
            $table->string('accident_happen_description', 1024)->nullable()->comment('事件發生描述');
            $table->string('cause_of_accident_description', 1024)->nullable()->comment('發生原因描述');
            $table->string('improve_strategy_desciption', 1024)->nullable()->comment('改善對策描述');
            $table->string('pension_situation_description')->nullable()->comment('體恤情況描述');
            $table->timestamps();
        });

        Schema::create('contract_relationship_images', function (Blueprint $table) {
            $table->id()->comment('承攬關係圖片編號');
            $table->string('url', 256)->comment('承攬關係圖片網址');
            $table->bigInteger('ar_id')->unsigned()->comment('職災紀錄編號');
            $table->foreign('ar_id')->references('id')->on('accident_records');
        });

        Schema::create('cause_of_accident_images', function (Blueprint $table) {
            $table->id()->comment('發生原因圖片編號');
            $table->string('url', 256)->comment('發生原因圖片網址');
            $table->bigInteger('ar_id')->unsigned()->comment('職災紀錄編號');
            $table->foreign('ar_id')->references('id')->on('accident_records');
        });

        Schema::create('improve_strategy_images', function (Blueprint $table) {
            $table->id()->comment('改善對策圖片編號');
            $table->string('url', 256)->comment('改善對策圖片網址');
            $table->bigInteger('ar_id')->unsigned()->comment('職災紀錄編號');
            $table->foreign('ar_id')->references('id')->on('accident_records');
        });

        Schema::create('victims', function (Blueprint $table) {
            $table->id()->comment('罹災者編號');
            $table->string('name', 30)->nullable()->comment('姓名');
            $table->string('id_number', 20)->nullable()->comment('身分證字號');
            $table->string('service_unit', 50)->nullable()->comment('服務單位');
            $table->string('phone', 20)->nullable()->comment('聯絡號碼');
            $table->date('employment_date')->nullable()->comment('到職日期');
            $table->date('birthday')->nullable()->comment('出生日期');
            $table->string('address', 100)->nullable()->comment('位址');
            $table->string('degree_of_injury', 50)->nullable()->comment('受傷程度');
            $table->bigInteger('ar_id')->unsigned()->comment('職災紀錄編號');
            $table->foreign('ar_id')->references('id')->on('accident_records');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('victims', function (Blueprint $table) {
            $table->dropForeign(['ar_id']);
        });
        Schema::dropIfExists('victims');
        Schema::table('improve_strategy_images', function (Blueprint $table) {
            $table->dropForeign(['ar_id']);
        });
        Schema::dropIfExists('improve_strategy_images');
        Schema::table('cause_of_accident_images', function (Blueprint $table) {
            $table->dropForeign(['ar_id']);
        });
        Schema::dropIfExists('cause_of_accident_images');
        Schema::table('contract_relationship_images', function (Blueprint $table) {
            $table->dropForeign(['ar_id']);
        });
        Schema::dropIfExists('contract_relationship_images');
        Schema::dropIfExists('accident_records');
    }
};
