<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\GratitudeStory;

class GratitudeController extends Controller
{
    public function index()
    {
        $gratitudeStory = $this->getGratitudeStory();
        return view('welcome', compact('gratitudeStory'));
    }
   

    public function getGratitudeStory()
    {
        $apiKey = env('OPENAI_API_KEY');
        
        if (!$apiKey || $apiKey === 'your_openai_api_key_here') {
            return [
                'title' => 'Sample Gratitude Story',
                'content' => 'This is a sample gratitude story. Please configure your OpenAI API key in the .env file to generate dynamic stories about gratitude and thankfulness.'
            ];
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
            ])->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You are a storyteller who creates inspiring and heartwarming gratitude stories. Write exactly 300 words.'
                    ],
                    [
                        'role' => 'user',
                        'content' => 'Write a beautiful and inspiring 300-word story about gratitude. The story should be personal, touching, and demonstrate the power of being thankful. Include specific details and emotions that make the story relatable and meaningful.'
                    ]
                ],
                'max_tokens' => 400,
                'temperature' => 0.7,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return [
                    'title' => 'A Story of Gratitude',
                    'content' => $data['choices'][0]['message']['content'] ?? 'Unable to generate story.'
                ];
            }
        } catch (\Exception $e) {
            Log::error('Failed to generate gratitude story: ' . $e->getMessage());
        }

        return [
            'title' => 'Sample Gratitude Story',
            'content' => 'This is a sample gratitude story. Please check your OpenAI API configuration to generate dynamic stories about gratitude and thankfulness.'
        ];
    }

    public function updateGratitude(Request $request)
    {
        $request->validate([
            'gratitude' => 'required|string|max:2000',
        ]);

        $userPrompt = $request->input('gratitude');
        $sessionId = session()->getId();

        try {
            $generatedStory = $this->generateStoryFromPrompt($userPrompt);
            
            $gratitudeStory = GratitudeStory::create([
                'user_prompt' => $userPrompt,
                'generated_story' => $generatedStory['content'],
                'title' => $generatedStory['title'],
                'session_id' => $sessionId,
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
        $apiKey = env('OPENAI_API_KEY');
        
        if (!$apiKey || $apiKey === 'your_openai_api_key_here') {
            return [
                'title' => 'Sample Response',
                'content' => 'This is a sample response based on your prompt: "' . $userPrompt . '". Please configure your OpenAI API key to generate AI stories.'
            ];
        }

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiKey,
            'Content-Type' => 'application/json',
        ])->post('https://api.openai.com/v1/chat/completions', [
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => 'You are a storyteller who creates inspiring and heartwarming gratitude stories. Write exactly 300 words based on the user\'s prompt.'
                ],
                [
                    'role' => 'user',
                    'content' => 'Based on this prompt about gratitude: "' . $userPrompt . '", write a beautiful and inspiring 300-word story about gratitude. Make it personal, touching, and demonstrate the power of being thankful.'
                ]
            ],
            'max_tokens' => 400,
            'temperature' => 0.7,
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
