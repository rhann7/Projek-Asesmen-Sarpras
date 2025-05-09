<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{   public function up(): void
    {
        Schema::create('unit_items', function (Blueprint $table) {
            $table->id();
            $table->string('unit_code')->unique();
            $table->foreignId('item_id')->constrained('items')->onDelete('cascade');
            $table->foreignId('location_id')->constrained('locations')->onDelete('cascade');
            $table->enum('condition', ['good', 'bad', 'broken'])->default('good');
            $table->enum('status', ['available', 'borrowed', 'used', 'repaired', 'lost'])->default('available');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('unit_items');
    }
};
