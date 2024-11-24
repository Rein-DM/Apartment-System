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
        Schema::create('inquiries', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('contact_number');
            $table->string('email');
            $table->string('price');
            $table->string('room_number');
            $table->string('valid_id')->nullable(); // To store the file path of the uploaded ID
            $table->boolean('agreement'); // Store agreement checkbox status
            $table->string('inquiry_status')->nullable();
            $table->tinyInteger('status')->default(1); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inquiries');
    }
};
