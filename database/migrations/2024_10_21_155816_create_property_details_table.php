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
        Schema::create('property_details', function (Blueprint $table) {
            $table->id();
            $table->integer('area');
            $table->string('floor_number');
            $table->string('type_of_ownership');
            $table->integer('number_of_rooms');
            $table->string('seller_type');
            $table->string('furnishing');
            $table->string('direction');
            $table->string('condition');
            $table->foreignId('ad_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_details');
    }
};
