<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Kost;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function start(Kost $kost)
    {
        $user = Auth::user();

        abort_unless(
            $user->role === 'student',
            403
        );

        $conversation = Conversation::firstOrCreate([
            'student_id' => $user->id,
            'owner_id' => $kost->owner_id,
            'kost_id' => $kost->id,
        ]);

        return redirect()->route(
            'chat.show',
            $conversation
        );
    }

    public function show(Conversation $conversation)
    {
        $user = Auth::user();

        abort_unless(
            $conversation->student_id === $user->id ||
            $conversation->owner_id === $user->id,
            403
        );

        $conversation->load([
            'student',
            'owner',
            'kost',
        ]);

       
        $conversation->messages()
            ->where('sender_id', '!=', $user->id)
            ->where('is_read', false)
            ->update([
                'is_read' => true,
            ]);

        return view(
            'chat.show',
            compact('conversation')
        );
    }

   
    public function messages(
        Request $request,
        Conversation $conversation
    ) {
        $user = Auth::user();

        abort_unless(
            $conversation->student_id === $user->id ||
            $conversation->owner_id === $user->id,
            403
        );

        $query = $conversation->messages()
            ->with('sender')
            ->oldest();

       
        if ($request->filled('after')) {
            $query->where(
                'id',
                '>',
                $request->integer('after')
            );
        }

        $messages = $query->get();

      
        $conversation->messages()
            ->where('sender_id', '!=', $user->id)
            ->where('is_read', false)
            ->update([
                'is_read' => true,
            ]);

        return response()->json([
            'messages' => $messages,
        ]);
    }

    
    public function send(
        Request $request,
        Conversation $conversation
    ) {
        $user = Auth::user();

        abort_unless(
            $conversation->student_id === $user->id ||
            $conversation->owner_id === $user->id,
            403
        );

        $validated = $request->validate([
            'message' => [
                'required',
                'string',
                'max:2000',
            ],
        ]);

        $message = Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => $user->id,
            'message' => $validated['message'],
            'is_read' => false,
        ]);

        $message->load('sender');

        return response()->json([
            'success' => true,
            'message' => $message,
        ]);
    }

    /**
     * Daftar percakapan milik student yang sedang login.
     */
    public function index()
    {
        $user = Auth::user();

        abort_unless(
            $user->role === 'student',
            403
        );

        $conversations = Conversation::with([
            'owner',
            'kost',
        ])
            ->where('student_id', $user->id)
            ->withCount([
                'messages as unread_count' => function ($query) use ($user) {
                    $query
                        ->where('sender_id', '!=', $user->id)
                        ->where('is_read', false);
                }
            ])
            ->latest('updated_at')
            ->get();

        return view(
            'chat.index',
            compact('conversations')
        );
    }

    public function ownerIndex()
{
    $user = Auth::user();

    abort_unless(
        $user->role === 'owner',
        403
    );

    $conversations = Conversation::with([
        'student',
        'kost',
    ])
        ->where('owner_id', $user->id)
        ->withCount([
            'messages as unread_count' => function ($query) use ($user) {
                $query
                    ->where('sender_id', '!=', $user->id)
                    ->where('is_read', false);
            }
        ])
        ->latest('updated_at')
        ->get();

    return view(
        'owner.chat.index',
        compact('conversations')
    );
}
}