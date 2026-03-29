<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('mode', 20);
            $table->smallInteger('level')->unsigned();
            $table->integer('current_question')->unsigned()->default(0);
            $table->boolean('is_completed')->default(false);
            $table->timestamps();

            $table->unique(['user_id', 'mode', 'level']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_progress');
    }
};
