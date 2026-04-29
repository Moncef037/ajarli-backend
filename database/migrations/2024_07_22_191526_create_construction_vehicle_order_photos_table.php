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
        Schema::create('construction_vehicle_order_photos', function (Blueprint $table) {
            $table->id();
            $table->string("path");

            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')->references('id')->on('construction_vehicle_orders')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('construction_vehicle_order_photos');
    }
};
