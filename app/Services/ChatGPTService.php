<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatGPTService
{
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = env('OPENAI_API_KEY');
        $this->baseUrl = 'https://api.openai.com/v1/chat/completions';
    }

    public function ask($message, $page = 'Content', $rule = 'review')
    {
        if (!$this->apiKey || $this->apiKey === 'your_openai_api_key_here') {
            throw new \Exception('OpenAI API key is not configured. Please add your API key to the .env file.');
        }

        try {
            $systemPrompt = $this->getSystemPrompt($page, $rule);
            
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->timeout(30)->post($this->baseUrl, [
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => $systemPrompt
                    ],
                    [
                        'role' => 'user',
                        'content' => $message
                    ]
                ],
                'max_tokens' => 1000,
                'temperature' => 0.7,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return $data['choices'][0]['message']['content'] ?? 'Unable to generate response.';
            } else {
                $errorData = $response->json();
                $errorMessage = $errorData['error']['message'] ?? 'Unknown error occurred';
                throw new \Exception('OpenAI API Error: ' . $errorMessage);
            }
        } catch (\Exception $e) {
            Log::error('ChatGPT Service Error: ' . $e->getMessage());
            throw $e;
        }
    }

    protected function getSystemPrompt($page, $rule)
    {
        $prompts = [
            'Content' => [
                'review' => 'You are an expert writing coach and editor. Your task is to review and improve written content about gratitude. Please:

1. Analyze the content for clarity, emotional impact, and authenticity
2. Improve grammar, spelling, and sentence structure
3. Enhance the emotional depth and personal connection
4. Ensure the content flows naturally and is engaging
5. Maintain the original voice and meaning while making it more compelling
6. Provide constructive feedback and suggestions for improvement

Please provide an improved version of the content that is more polished, engaging, and emotionally resonant while preserving the original intent and personal nature of the gratitude expression.',
                
                'expand' => 'You are a gratitude writing specialist. Help expand and enrich the given gratitude content by adding more detail, emotional depth, and specific examples while maintaining authenticity.',
                
                'simplify' => 'You are a writing clarity expert. Help simplify and clarify the given gratitude content, making it more accessible and easier to understand while preserving its emotional impact.'
            ]
        ];

        return $prompts[$page][$rule] ?? $prompts['Content']['review'];
    }
}