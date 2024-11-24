<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('phone_number');
            // $table->decimal('amount', 10, 2);
            $table->string('amount');
            $table->string('qr_code')->nullable();
            $table->string('payment_method'); // New field for payment method
            $table->json('due_date'); // To store multiple due dates as JSON
            $table->tinyInteger('status')->default(1);
            $table->string('receipt_path')->nullable();
            $table->string('reasons')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
