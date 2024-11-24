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
        Schema::create('apartment_rooms', function (Blueprint $table) {
            $table->id(); 
            $table->string('title');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->boolean('condition_agreement')->nullable();
            $table->string('full_name');
            $table->string('contact_number'); 
            $table->string('email')->unique();
            $table->string('valid_id'); 
            $table->softDeletes();
            $table->tinyInteger('status')->default(1); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apartment_rooms');
    }
};
