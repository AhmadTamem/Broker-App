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
        Schema::create('car_details', function (Blueprint $table) {
            $table->id();
            $table->string('car_condition');
            $table->string('make');
            $table->string('vehicle_class');
            $table->string('transmission');
            $table->integer('manufacturing_year');
            $table->integer('kilometers');
            $table->string('color');
            $table->string('fuel');
            $table->string('engine_capacity');
            $table->string('seller_type');
            $table->foreignId('ad_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_details');
    }
};
