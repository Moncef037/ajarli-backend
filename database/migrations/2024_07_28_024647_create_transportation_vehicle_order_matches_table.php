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
        Schema::create('transportation_vehicle_order_matches', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id', 'fk_tvom_order_id')->references('id')->on('transportation_vehicle_orders')->onDelete('cascade');

            $table->unsignedBigInteger('provider_id');
            $table->foreign('provider_id', 'fk_tvom_provider_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('transportation_vehicle_id');
            $table->foreign('transportation_vehicle_id', 'fk_tvom_vehicle_id')->references('id')->on('vehicles')->onDelete('cascade');

            $table->decimal('price_per_day', 8, 2);
            $table->decimal('price_of_distance', 8, 2);
            $table->decimal('operator_price', 8, 2);
            $table->decimal('total_price', 10, 2);

            $table->enum(
                'status',
                [
                    'pending',
                    'accepted_by_renter',
                    'accepted_by_provider',
                    'negotiation',
                    'settled'
                ]
            )->default('pending');

            $table->timestamp('renter_accepted_at')->nullable();
            $table->timestamp('provider_accepted_at')->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transportation_vehicle_order_matches');
    }
};
