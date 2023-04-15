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
            $table->string('id', 15)->comment('機關代碼');
            $table->string('agency_name', 35)->comment('機關名稱');
            $table->string('address', 35)->comment('地址');
            $table->string('notifed_hotline_at_work', 20)->comment('上班時段通報專線');
            $table->string('notifed_hotline_off_work', 20)->comment('下班時段通報專線');
            // $table->timestamps();
            $table->primary('id');
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
