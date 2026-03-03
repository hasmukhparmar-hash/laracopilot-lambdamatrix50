<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('patient_id', 20)->unique();
            $table->string('name', 150);
            $table->integer('age');
            $table->enum('gender', ['Male', 'Female', 'Other']);
            $table->string('phone', 20);
            $table->string('email', 150)->nullable();
            $table->text('address')->nullable();
            $table->string('blood_group', 5)->nullable();
            $table->date('dob')->nullable();
            $table->string('emergency_contact', 20)->nullable();
            $table->text('allergies')->nullable();
            $table->text('chronic_diseases')->nullable();
            $table->string('referred_by', 150)->nullable();
            $table->timestamps();
        });

        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->string('specialization', 150);
            $table->string('email', 150)->nullable();
            $table->string('phone', 20);
            $table->string('qualification', 200)->nullable();
            $table->integer('experience_years')->nullable();
            $table->decimal('consultation_fee', 10, 2)->default(0);
            $table->boolean('active')->default(true);
            $table->string('schedule', 500)->nullable();
            $table->timestamps();
        });

        Schema::create('nurses', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->string('email', 150)->nullable();
            $table->string('phone', 20);
            $table->enum('shift', ['Morning', 'Evening', 'Night'])->default('Morning');
            $table->string('department', 100)->nullable();
            $table->boolean('active')->default(true);
            $table->json('permissions')->nullable();
            $table->timestamps();
        });

        Schema::create('medicines', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200);
            $table->string('generic_name', 200)->nullable();
            $table->enum('category', ['Tablet', 'Syrup', 'Injection', 'Capsule', 'Cream', 'Drops', 'Inhaler', 'Other']);
            $table->string('manufacturer', 150)->nullable();
            $table->decimal('unit_price', 10, 2)->default(0);
            $table->enum('unit', ['Piece', 'Strip', 'Bottle', 'Vial', 'Tube', 'Box'])->default('Piece');
            $table->text('description')->nullable();
            $table->text('side_effects')->nullable();
            $table->text('contraindications')->nullable();
            $table->boolean('requires_prescription')->default(false);
            $table->timestamps();
        });

        Schema::create('medicine_stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medicine_id')->constrained()->onDelete('cascade');
            $table->integer('quantity')->default(0);
            $table->integer('reorder_level')->default(10);
            $table->date('expiry_date')->nullable();
            $table->string('batch_number', 50)->nullable();
            $table->decimal('purchase_price', 10, 2)->nullable();
            $table->string('supplier', 150)->nullable();
            $table->timestamps();
        });

        Schema::create('inspections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->foreignId('doctor_id')->constrained()->onDelete('cascade');
            $table->date('inspection_date');
            $table->text('chief_complaint');
            $table->text('diagnosis');
            $table->text('symptoms')->nullable();
            $table->string('vitals_bp', 20)->nullable();
            $table->string('vitals_temp', 20)->nullable();
            $table->string('vitals_pulse', 20)->nullable();
            $table->string('vitals_weight', 20)->nullable();
            $table->text('notes')->nullable();
            $table->date('follow_up_date')->nullable();
            $table->timestamps();
        });

        Schema::create('inspection_medicine', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inspection_id')->constrained()->onDelete('cascade');
            $table->foreignId('medicine_id')->constrained()->onDelete('cascade');
            $table->string('dosage', 100);
            $table->string('duration', 100);
            $table->integer('quantity')->default(1);
            $table->timestamps();
        });

        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->foreignId('doctor_id')->constrained()->onDelete('cascade');
            $table->foreignId('inspection_id')->nullable()->constrained()->onDelete('set null');
            $table->string('bill_number', 30)->unique();
            $table->date('bill_date');
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->enum('payment_status', ['pending', 'paid', 'partial'])->default('pending');
            $table->string('payment_method', 30)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('bill_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bill_id')->constrained()->onDelete('cascade');
            $table->string('description', 200);
            $table->integer('quantity')->default(1);
            $table->decimal('unit_price', 10, 2)->default(0);
            $table->decimal('total', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bill_items');
        Schema::dropIfExists('bills');
        Schema::dropIfExists('inspection_medicine');
        Schema::dropIfExists('inspections');
        Schema::dropIfExists('medicine_stocks');
        Schema::dropIfExists('medicines');
        Schema::dropIfExists('nurses');
        Schema::dropIfExists('doctors');
        Schema::dropIfExists('patients');
    }
};