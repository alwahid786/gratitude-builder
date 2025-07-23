<?php

namespace App\Http\Controllers;

use App\Models\UserRequest;
use App\Services\ChatGPTService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ChatGPTController extends Controller
{
    protected $chatGPT;

    public function __construct(ChatGPTService $chatGPT)
    {
        $this->chatGPT = $chatGPT;
    }

    public function ask(Request $request)
    {
        $validated = $request->validate([
            'message' => 'required|string',
            'page' => 'required|string',
        ]);

        try {
            $user = Auth::user();
            $today = Carbon::today()->toDateString();
            $page = $validated['page'];
            $rule = $request->input('rule');
                $response = $this->chatGPT->ask($validated['message'], $page, $rule);
                return response()->json(['response' => $response]);

        } catch (\Exception $e) {
            Log::error('Error processing request: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}

