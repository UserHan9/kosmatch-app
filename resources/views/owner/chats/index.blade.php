@extends('layouts.app')

@section('title', 'Chat - KosMatch')

@section('page-title', 'Chat')

@section('content')

<div style="max-width: 1000px; margin: 0 auto;">

    <div
        style="
            background:white;
            border-radius:14px;
            padding:24px;
            box-shadow:0 1px 4px rgba(0,0,0,.08);
        "
    >

        <h2 style="margin-bottom:20px;">
            💬 Chat
        </h2>

        @if($conversations->count() === 0)

            <div
                style="
                    padding:40px;
                    text-align:center;
                    color:#6b7280;
                "
            >
                Belum ada percakapan.
            </div>

        @else

            @foreach($conversations as $conversation)

                <a
                    href="{{ route('chat.show', $conversation) }}"
                    style="
                        display:flex;
                        align-items:center;
                        justify-content:space-between;
                        padding:18px;
                        margin-bottom:12px;
                        border:1px solid #e5e7eb;
                        border-radius:12px;
                        text-decoration:none;
                        color:#111827;
                        transition:.2s;
                    "
                >

                    <div style="display:flex; align-items:center; gap:15px;">

                      
                        <div
                            style="
                                width:45px;
                                height:45px;
                                border-radius:50%;
                                background:#111827;
                                color:white;
                                display:flex;
                                align-items:center;
                                justify-content:center;
                                font-weight:bold;
                            "
                        >
                            {{ strtoupper(substr($conversation->student->name, 0, 1)) }}
                        </div>


                     
                        <div>

                            <div
                                style="
                                    font-weight:600;
                                    font-size:16px;
                                "
                            >
                                {{ $conversation->student->name }}
                            </div>

                            <div
                                style="
                                    font-size:13px;
                                    color:#6b7280;
                                    margin-top:3px;
                                "
                            >
                                {{ $conversation->kost->name }}
                            </div>

                        </div>

                    </div>


                    
                    @if($conversation->unread_count > 0)

                        <div
                            style="
                                min-width:24px;
                                height:24px;
                                padding:0 7px;
                                border-radius:20px;
                                background:#ef4444;
                                color:white;
                                display:flex;
                                align-items:center;
                                justify-content:center;
                                font-size:12px;
                                font-weight:bold;
                            "
                        >
                            {{ $conversation->unread_count }}
                        </div>

                    @else

                        <div style="color:#9ca3af;">
                            ›
                        </div>

                    @endif

                </a>

            @endforeach

        @endif

    </div>

</div>

@endsection