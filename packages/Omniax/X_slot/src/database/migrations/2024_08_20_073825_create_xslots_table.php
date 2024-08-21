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
        Schema::create('xslots', function (Blueprint $table) {
            $table->id();
            $table->string('slot_time'); // e.g., '9 AM - 12 PM'
            $table->dateTime('start_time'); 
            $table->dateTime('end_time'); 
            $table->integer('capacity')->default(0); // Max number of orders
            $table->integer('current_orders')->default(0); // Number of booked orders
            $table->timestamp('date'); // Date for the slot
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('xslots');
    }
};
