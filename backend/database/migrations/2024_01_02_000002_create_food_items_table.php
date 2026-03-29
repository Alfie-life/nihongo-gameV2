<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('food_items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('name_en');
            $table->string('emoji', 10);
            $table->string('category', 30);
            $table->string('mode', 20);
            $table->smallInteger('level')->unsigned();
            $table->integer('question_index')->unsigned();
            $table->timestamps();

            $table->index(['mode', 'level']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('food_items');
    }
};
