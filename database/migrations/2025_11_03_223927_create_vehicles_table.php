<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id')->constrained()->cascadeOnDelete();
            $table->foreignId('car_model_id')->constrained()->cascadeOnDelete();
            $table->foreignId('color_option_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->integer('year');
            $table->unsignedInteger('mileage');
            $table->decimal('price', 12, 2);
            $table->string('main_photo_url');
            $table->string('transmission')->nullable();
            $table->string('fuel_type')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
