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
        Schema::create('booking_customer', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customer_id')->unsigned();

            $table->foreign('customer_id')
                ->references('id')
                ->on('customers')->onDelete('cascade');

            $table->integer('booking_id')->unsigned();
            $table->foreign('booking_id')
                ->references('id')
                ->on('bookings')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_customer');
    }
};
