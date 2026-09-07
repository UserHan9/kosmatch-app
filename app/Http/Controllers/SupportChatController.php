<?php

namespace App\Http\Controllers;

use App\Services\GeminiChatService;
use Illuminate\Http\Request;

class SupportChatController extends Controller
{
    public function index()
    {
        return view('student.support.index');
    }

    public function send(Request $request, GeminiChatService $chat)
    {
        $validated = $request->validate([
            'message' => ['required', 'string', 'max:1000'],
            'history' => ['array'],
            'history.*.role' => ['required_with:history', 'in:user,assistant'],
            'history.*.content' => ['required_with:history', 'string'],
        ]);

        $history = $validated['history'] ?? [];
        $history = array_slice($history, -10);

        $history[] = [
            'role' => 'user',
            'content' => $validated['message'],
        ];

        $reply = $chat->reply($history);

        return response()->json([
            'reply' => $reply,
        ]);
    }
}