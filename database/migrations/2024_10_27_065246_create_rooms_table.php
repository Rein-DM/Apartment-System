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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('room_number')->unique();
            $table->string('type'); // e.g., Single, Double, Suite
            $table->decimal('price', 8, 2);
            $table->integer('capacity'); // Maximum number of occupants
            $table->text('description')->nullable();
            $table->boolean('available')->default(true); // Room availability status
            $table->string('apartment_image')->nullable();
            $table->string('bathroom_image')->nullable();
            $table->string('outside_image')->nullable();
            $table->string('occupied_image')->nullable();
            $table->string('vacant_image')->nullable();
            $table->tinyInteger('status')->default(1); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
