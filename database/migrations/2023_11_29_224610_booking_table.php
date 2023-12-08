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
        Schema::create('bookings', function (Blueprint $table) {
            $table->increments("id");
            $table->dateTime('check-in');
            $table->dateTime('check-out')->nullable();
            $table->decimal('amount');
            $table->integer('nights');

            $table->integer('hotel_id')->unsigned();
            $table->foreign('hotel_id')
                ->references('id')->on('hotels')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
