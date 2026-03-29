<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->string('mode', 20); // 'aru_iru' or 'dashi_shi'
            $table->smallInteger('level')->unsigned(); // 1-10
            $table->text('sentence');
            $table->string('correct_answer', 10);
            $table->string('wrong_answer', 10);
            $table->text('explanation')->nullable();
            $table->timestamps();

            $table->index(['mode', 'level']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
