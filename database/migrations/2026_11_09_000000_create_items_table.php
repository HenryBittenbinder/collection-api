<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('category');
            $table->string('brand')->nullable();
            $table->text('description')->nullable();
            $table->string('condition');
            $table->decimal('estimated_value', 10, 2)->nullable();
            $table->decimal('asking_price', 10, 2)->nullable();
            $table->string('availability');
            $table->string('photo')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
