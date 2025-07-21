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
        Schema::create('gratitude_stories', function (Blueprint $table) {
            $table->id();
            $table->text('user_prompt');
            $table->text('generated_story');
            $table->string('title')->default('A Story of Gratitude');
            $table->string('session_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gratitude_stories');
    }
};
