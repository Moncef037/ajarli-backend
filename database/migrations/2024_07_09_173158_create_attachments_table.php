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
        Schema::create('attachments', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('sub_category_id');
            $table->foreign('sub_category_id')->references('id')->on('vehicle_sub_categories')->onDelete('cascade');

            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->year('year')->nullable();
            $table->decimal('price_per_day', 8, 2)->nullable();
            $table->decimal('price_per_month', 8, 2)->nullable();
            $table->enum('offer_type', ['fixed', 'negotiable'])->nullable();
            $table->decimal('transport_price', 8, 2)->nullable();
            $table->string('region')->nullable();
            $table->string('city')->nullable();
            $table->string('phone_number')->nullable();
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
        Schema::dropIfExists('attachments');
    }
};
