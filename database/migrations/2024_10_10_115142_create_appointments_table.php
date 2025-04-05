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
            Schema::create('appointments', function (Blueprint $table) {
                $table->id(); // Primary key
                $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Add user_id as a foreign key
                $table->string('transaction_number')->unique(); // Unique transaction number
                $table->string('first_name'); // Patient's first name
                $table->string('last_name'); // Patient's last name
                $table->date('date_of_birth')->nullable(); // Patient's date of birth
                $table->date('appointment_date'); // Appointment date
                $table->time('appointment_time'); // Appointment time
                $table->string('visit_type'); // Type of visit (e.g., consultation, follow-up)
                $table->text('additional')->nullable(); // Additional details, optional
                $table->string('doctor')->nullable(); // Doctor's name
                $table->enum('gender', ['male', 'female', 'other'])->nullable(); // Gender
                $table->string('marital_status')->nullable(); // Marital status, optional
                $table->string('contact_number')->nullable(); // Contact number
                $table->string('email_address')->nullable(); // Email address
                $table->text('complete_address')->nullable(); // Complete address
                $table->json('amount')->nullable();
                $table->decimal('discount', 5, 2)->default(0);
                $table->enum('status', ['pending', 'approved', 'completed', 'rejected', 'cancelled'])->default('pending'); // Appointment status
                $table->text('notes')->nullable(); // Additional notes, optional
                $table->json('descriptions')->nullable(); // Store multiple invoice descriptions as JSON
                $table->json('qty')->nullable(); // Store multiple quantities as JSON
                $table->json('drugname')->nullable(); // Store multiple drug names as JSON
                $table->json('dosage')->nullable(); // Store multiple dosages as JSON
                $table->json('doctorqty')->nullable(); // Store multiple doctor quantities as JSON
                $table->text('diagnosis')->nullable(); 
                $table->timestamps(); // Laravel's created_at and updated_at columns
            });
        

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
