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
        Schema::table('appointments', function (Blueprint $table) {
            $table->string('id_number')->nullable()->after('discount');
            $table->string('id_type')->nullable()->after('id_number');
            $table->integer('follow_up')->default(0)->after('id_type'); // Add follow_up column
        }); 
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn(['id_number', 'id_type']);
        });
    }
};
