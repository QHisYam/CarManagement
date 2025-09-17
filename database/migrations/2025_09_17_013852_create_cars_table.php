<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('make'); // e.g., Toyota, Honda
            $table->string('model'); // e.g., Camry, Civic
            $table->integer('year'); // safer than year()
            $table->decimal('price', 10, 2); // up to 99,999,999.99
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
