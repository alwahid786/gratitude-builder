<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GratitudeStory;
use App\Models\AdminSetting; // new code
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class GratitudeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $input_limit = 500; // Set a reasonable word limit for AI review
        
        // Get default story settings from admin
        $gratitudeStory = [
            'title' => AdminSetting::getValue('default_story_title', 'Your Gratitude Story'),
            'content' => AdminSetting::getValue('default_story_content', 'Welcome to your gratitude journey. Your personalized story will appear here once you create it.')
        ];
        
        return view('welcome', compact('user', 'input_limit', 'gratitudeStory'));
    }
   

    public function updateGratitude(Request $request)
    {
        $request->validate([
            'gratitude' => 'required|string|max:2000',
        ]);

        $userPrompt = $request->input('gratitude');
        $sessionId = session()->getId();
        $user = Auth::user();

        try {
       

            $generatedStory = $this->generateStoryFromPrompt($userPrompt);
            
            $gratitudeStory = GratitudeStory::create([
                'user_prompt' => $userPrompt,
                'generated_story' => $generatedStory['content'],
                'title' => $generatedStory['title'],
                'session_id' => $sessionId,
                'user_id' => $user ? $user->id : null,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Story generated successfully!',
                'story' => $generatedStory,
                'id' => $gratitudeStory->id
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate story. Please try again.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    private function generateStoryFromPrompt($userPrompt)
    {
        // new code - Use database settings
        $apiKey = AdminSetting::getValue('openai_api_key', env('OPENAI_API_KEY'));
        
        if (!$apiKey || $apiKey === 'your_openai_api_key_here') {
            return [
                'title' => 'Sample Response',
                'content' => 'This is a sample response based on your prompt: "' . $userPrompt . '". Please configure your OpenAI API key to generate AI stories.'
            ];
        }

        $model = AdminSetting::getValue('openai_model', 'gpt-3.5-turbo');
        $maxTokens = (int) AdminSetting::getValue('max_tokens', 400);
        $temperature = (float) AdminSetting::getValue('temperature', 0.7);
        $systemPrompt = AdminSetting::getValue('story_generation_prompt', 
            'You are a storyteller who creates inspiring and heartwarming gratitude stories. Write exactly 300 words based on the user\'s prompt.'
        );
        $completionPrompt = AdminSetting::getValue('completion_prompt', 
            'Based on this prompt about gratitude: "{prompt}", write a beautiful and inspiring 300-word story about gratitude. Make it personal, touching, and demonstrate the power of being thankful.'
        );

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiKey,
            'Content-Type' => 'application/json',
        ])->post('https://api.openai.com/v1/chat/completions', [
            'model' => $model,
            'messages' => [
                [
                    'role' => 'system',
                    'content' => $systemPrompt
                ],
                [
                    'role' => 'user',
                    'content' => str_replace('{prompt}', $userPrompt, $completionPrompt)
                ]
            ],
            'max_tokens' => $maxTokens,
            'temperature' => $temperature,
        ]);

        if ($response->successful()) {
            $data = $response->json();
            return [
                'title' => 'Your Personal Gratitude Story',
                'content' => $data['choices'][0]['message']['content'] ?? 'Unable to generate story.'
            ];
        }

        throw new \Exception('Failed to generate story from OpenAI API');
    }
}
