<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('residents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->constrained()->onDelete('cascade');
            $table->string('name', 150);
            $table->string('email', 150)->nullable();
            $table->string('phone', 20);
            $table->date('move_in_date');
            $table->date('move_out_date')->nullable();
            $table->enum('id_proof_type', ['Aadhar', 'PAN', 'Passport', 'Driving License']);
            $table->string('id_proof_number', 50);
            $table->string('emergency_contact', 20)->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->integer('members_count')->default(1);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('residents');
    }
};