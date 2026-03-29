<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('food_collections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('food_item_id')->constrained()->onDelete('cascade');
            $table->string('mode', 20);
            $table->smallInteger('level')->unsigned();
            $table->timestamp('obtained_at');
            $table->timestamps();

            $table->unique(['user_id', 'food_item_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('food_collections');
    }
};
