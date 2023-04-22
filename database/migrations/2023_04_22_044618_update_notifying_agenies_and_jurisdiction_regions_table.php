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
            $table->dropPrimary('id');
            $table->smallInteger('id')->change();
        });

        Schema::table('notifying_agencies', function (Blueprint $table) {
            $table->dropPrimary('id');
            $table->smallInteger('id')->change();
        });

        Schema::table('notifying_agencies', function (Blueprint $table) {
            $table->smallIncrements('id')->comment('機關編號')->change();
        });

        Schema::table('jurisdiction_regions', function (Blueprint $table) {
            $table->smallIncrements('id')->comment('管轄區編號')->change();
            $table->smallInteger('na_id')->comment('機關編號')->unsigned()->change();
            $table->foreign('na_id')->references('id')->on('notifying_agencies');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
