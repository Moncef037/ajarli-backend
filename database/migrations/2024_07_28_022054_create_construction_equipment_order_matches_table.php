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
        Schema::create('construction_equipment_order_matches', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id', 'fk_ceom_order_id')->references('id')->on('construction_equipment_orders')->onDelete('cascade');

            $table->unsignedBigInteger('provider_id');
            $table->foreign('provider_id', 'fk_ceom_provider_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('construction_equipment_id');
            $table->foreign('construction_equipment_id', 'fk_ceom_equipment_id')->references('id')->on('equipments')->onDelete('cascade');

            $table->decimal('price_per_day', 8, 2);
            $table->decimal('operator_price', 8, 2);
            $table->decimal('transport_price', 8, 2);
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
        Schema::dropIfExists('construction_equipment_order_matches');
    }
};
