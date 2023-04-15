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
            $table->dropPrimary(['na_id', 'region']);
            $table->dropColumn('na_id');
        });

        Schema::table('notifying_agencies', function (Blueprint $table) {
            $table->dropPrimary('id');
            $table->dropColumn('id');
            $table->primary('agency_name');
        });

        Schema::table('jurisdiction_regions', function (Blueprint $table) {
            $table->string('agency_name')->comment('機關名稱');
            $table->primary(['agency_name', 'region']);
            $table->foreign('agency_name')->references('agency_name')->on('notifying_agencies');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jurisdiction_regions', function (Blueprint $table) {
            $table->dropForeign(['agency_name']);
            $table->dropPrimary(['agency_name', 'region']);
            $table->dropColumn('agency_name');
        });

        Schema::table('notifying_agencies', function (Blueprint $table) {
            $table->dropPrimary('agency_name');
            $table->string('id', 15);
            $table->primary('id');
        });

        Schema::table('jurisdiction_regions', function (Blueprint $table) {
            $table->string('na_id', 15);
            $table->foreign('na_id')->references('id')->on('notifying_agencies');
            $table->primary(['na_id', 'region']);
        });
    }
};
