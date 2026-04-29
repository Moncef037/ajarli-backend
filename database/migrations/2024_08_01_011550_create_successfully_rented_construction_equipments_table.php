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
        Schema::create('successfully_rented_construction_equipments', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('match_id');
            $table->foreign('match_id')->references('id')->on('construction_equipment_order_matches')->onDelete('cascade');

            $table->enum('renter_activity_status', ['in_work', 'out_of_service', 'completed']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('successfully_rented_construction_equipments');
    }
};
