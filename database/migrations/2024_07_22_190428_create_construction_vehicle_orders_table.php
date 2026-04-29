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
        Schema::create('construction_vehicle_orders', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('sub_category_id');
            $table->foreign('sub_category_id')->references('id')->on('vehicle_sub_categories')->onDelete('cascade');

            $table->boolean('operator');
            $table->integer('capacity');
            $table->integer('quantity');
            $table->integer('duration');
            $table->date('start_date');
            $table->date('end_date');
            $table->time('hour');
            $table->enum('transport', ['by_yourself', 'by_us']);
            $table->text('more_details');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('construction_vehicle_orders');
    }
};
