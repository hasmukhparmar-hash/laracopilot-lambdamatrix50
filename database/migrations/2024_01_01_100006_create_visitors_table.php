<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('visitors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resident_id')->constrained()->onDelete('cascade');
            $table->string('visitor_name', 150);
            $table->string('visitor_phone', 20);
            $table->string('purpose', 200);
            $table->date('visit_date');
            $table->time('check_in');
            $table->time('check_out')->nullable();
            $table->string('vehicle_number', 20)->nullable();
            $table->string('id_proof', 100)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('visitors');
    }
};