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
        Schema::create('notifying_agencies', function (Blueprint $table) {
            $table->id()->comment('機關編號');
            $table->string('agency_name', 35)->comment('機關名稱');
            $table->string('address', 35)->comment('地址');
            $table->string('notified_hotline_at_work', 20)->comment('上班通報時段');
            $table->string('notified_hotline_off_work', 20)->comment('下班通報時段');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifying_agencies');
    }
};
