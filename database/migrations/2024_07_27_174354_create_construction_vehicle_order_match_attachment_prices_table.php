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
        Schema::create('construction_vehicle_order_match_attachment_prices', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('match_id');
            $table->foreign('match_id', 'fk_cvomap_match_id')->references('id')->on('construction_vehicle_order_matches')->onDelete('cascade');
            
            $table->unsignedBigInteger('attachment_id');
            $table->foreign('attachment_id', 'fk_cvomap_attachment_id')->references('id')->on('vehicle_attachments')->onDelete('cascade');

            $table->decimal('price', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('construction_vehicle_order_match_attachment_prices');
    }
};
