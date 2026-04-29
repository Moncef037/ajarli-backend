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
        Schema::create('equipments', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('equipment_categories')->onDelete('cascade');

            $table->unsignedBigInteger('sub_category_id');
            $table->foreign('sub_category_id')->references('id')->on('equipment_sub_categories')->onDelete('cascade');

            $table->string('brand');
            $table->string('model');
            $table->year('year');
            $table->decimal('price_per_day', 8, 2);
            $table->decimal('price_per_month', 8, 2);
            $table->enum('offer_type', ['fixed', 'negotiable']);
            $table->decimal('transport_price', 8, 2);
            $table->decimal('operator_price', 8, 2);
            $table->string('region');
            $table->string('city');
            $table->string('phone_number');
            $table->enum('activity_status', ['active', 'in_service', 'out_of_service']);
            $table->enum('approval_status', ['approved', 'not_approved']);

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
        Schema::dropIfExists('equipments');
    }
};
