<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\AdminSetting; // new code

class ChatGPTService
{
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        // new code - Use database settings instead of env
        $this->apiKey = AdminSetting::getValue('openai_api_key', env('OPENAI_API_KEY'));
        $this->baseUrl = 'https://api.openai.com/v1/chat/completions';
    }

    public function ask($message, $page = 'Content', $rule = 'review')
    {
        if (!$this->apiKey || $this->apiKey === 'your_openai_api_key_here') {
            throw new \Exception('OpenAI API key is not configured. Please add your API key to the .env file.');
        }

        try {
            $systemPrompt = $this->getSystemPrompt($page, $rule);
            
            // new code - Use database settings
            $model = AdminSetting::getValue('openai_model', 'gpt-3.5-turbo');
            $maxTokens = (int) AdminSetting::getValue('max_tokens', 1000);
            $temperature = (float) AdminSetting::getValue('temperature', 0.7);

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->timeout(30)->post($this->baseUrl, [
                'model' => $model,
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => $systemPrompt
                    ],
                    [
                        'role' => 'user',
                        'content' => "Please review and significantly improve the following gratitude content. Make substantial enhancements to grammar, vocabulary, flow, and emotional impact while keeping the core message:\n\n--- ORIGINAL CONTENT ---\n{$message}\n--- END ORIGINAL CONTENT ---\n\nReturn the improved version with enhanced language, better structure, and stronger emotional resonance. Format the output in clean HTML (no CSS) for CKEditor compatibility."
                    ]

                ],
                'max_tokens' => $maxTokens,
                'temperature' => $temperature,
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
        return AdminSetting::getValue('ai_review_prompt', 
            'You are an expert writing coach and editor. Your task is to review and improve written content about gratitude. Please analyze the content for clarity, emotional impact, and authenticity. Improve grammar, spelling, and sentence structure while maintaining the original voice.'
        );
    }
}