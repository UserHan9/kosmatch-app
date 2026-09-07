<?php

use App\Models\Conversation;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel(
    'conversation.{conversation}',
    function ($user, Conversation $conversation) {

        return $conversation->student_id === $user->id
            || $conversation->owner_id === $user->id;
    }
);