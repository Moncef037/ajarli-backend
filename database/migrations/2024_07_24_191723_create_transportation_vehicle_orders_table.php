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
        Schema::create('transportation_vehicle_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sub_category_id');
            $table->foreign('sub_category_id')->references('id')->on('vehicle_sub_categories')->onDelete('cascade');

            $table->boolean('operator');
            $table->integer('capacity');
            $table->integer('quantity');
            $table->boolean('equipments');

            $table->enum('your_need', ['per_day', 'per_distance']);
            
            $table->string('departure_location')->nullable();
            $table->string('arrival_location')->nullable();
            $table->integer('duration')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->time('hour')->nullable();
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
        Schema::dropIfExists('transportation_vehicle_orders');
    }
};
