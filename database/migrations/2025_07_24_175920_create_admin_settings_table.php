<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    // new code
    public function up(): void
    {
        Schema::create('admin_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('type')->default('text'); // text, textarea, number
            $table->string('group')->default('general'); // ai, general, etc
            $table->timestamps();
        });

        // Insert default AI settings
        DB::table('admin_settings')->insert([
            ['key' => 'openai_api_key', 'value' => env('OPENAI_API_KEY', ''), 'type' => 'text', 'group' => 'ai', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'openai_model', 'value' => 'gpt-3.5-turbo', 'type' => 'text', 'group' => 'ai', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'max_tokens', 'value' => '1000', 'type' => 'number', 'group' => 'ai', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'temperature', 'value' => '0.7', 'type' => 'number', 'group' => 'ai', 'created_at' => now(), 'updated_at' => now()],
            
            // UNUSED: Story generation functionality - only review is supported
            // ['key' => 'story_generation_prompt', 'value' => 'You are a storyteller who creates inspiring and heartwarming gratitude stories. Write exactly 300 words based on the user\'s prompt.', 'type' => 'textarea', 'group' => 'ai', 'created_at' => now(), 'updated_at' => now()],
            
            ['key' => 'ai_review_prompt', 'value' => 'You are an expert writing coach and editor. Your task is to review and improve written content about gratitude. Please analyze the content for clarity, emotional impact, and authenticity. Improve grammar, spelling, and sentence structure while maintaining the original voice.', 'type' => 'textarea', 'group' => 'ai', 'created_at' => now(), 'updated_at' => now()],
            
            // UNUSED: Completion prompt functionality - only review is supported
            // ['key' => 'completion_prompt', 'value' => 'Based on this prompt about gratitude: "{prompt}", write a beautiful and inspiring 300-word story about gratitude. Make it personal, touching, and demonstrate the power of being thankful.', 'type' => 'textarea', 'group' => 'ai', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_settings');
    }
};