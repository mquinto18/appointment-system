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
        Schema::table('appointment_slots', function (Blueprint $table) {
            $table->time('time')->after('appointment_date');
        });
    }

    public function down(): void
    {
        Schema::table('appointment_slots', function (Blueprint $table) {
            $table->dropColumn('time');
        });
    }
};
