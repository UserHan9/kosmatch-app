@extends('layouts.app2')

@section('title', 'Chat - ' . $conversation->kost->name)
@section('page-title', 'Chat')

@section('content')

<div
    style="
        max-width:800px;
        margin:0 auto;
        border:1px solid #ddd;
        border-radius:12px;
        overflow:hidden;
        background:white;
    "
>

    {{-- HEADER --}}
    <div
        style="
            padding:20px;
            background:#111827;
            color:white;
        "
    >

        @if(auth()->id() === $conversation->student_id)

            Chat dengan
            <strong>
                {{ $conversation->owner->name }}
            </strong>

        @else

            Chat dengan
            <strong>
                {{ $conversation->student->name }}
            </strong>

        @endif

        <div style="font-size:13px;">
            {{ $conversation->kost->name }}
        </div>

    </div>


    {{-- MESSAGES --}}
    <div
        id="messages"
        style="
            height:500px;
            overflow-y:auto;
            padding:20px;
            background:#f9fafb;
        "
    >

        @php
            $messages = $conversation->messages()
                ->with('sender')
                ->oldest()
                ->get();
        @endphp

        @foreach($messages as $message)

            <div
                class="message"
                data-id="{{ $message->id }}"
                style="
                    margin-bottom:12px;
                    text-align:
                    {{ $message->sender_id === auth()->id()
                        ? 'right'
                        : 'left' }};
                "
            >

                <div
                    style="
                        display:inline-block;
                        max-width:70%;
                        padding:10px 14px;
                        border-radius:12px;
                        background:
                        {{ $message->sender_id === auth()->id()
                            ? '#111827'
                            : '#e5e7eb' }};
                        color:
                        {{ $message->sender_id === auth()->id()
                            ? 'white'
                            : 'black' }};
                    "
                >

                    {{ $message->message }}

                </div>

            </div>

        @endforeach

    </div>


    {{-- FORM --}}
    <form
        id="chat-form"
        style="
            display:flex;
            gap:10px;
            padding:15px;
            border-top:1px solid #ddd;
        "
    >

        @csrf

        <input
            type="text"
            id="message-input"
            placeholder="Tulis pesan..."
            autocomplete="off"
            style="
                flex:1;
                padding:12px;
                border:1px solid #ddd;
                border-radius:8px;
            "
        >

        <button
            type="submit"
            style="
                padding:12px 20px;
                border:none;
                border-radius:8px;
                background:#111827;
                color:white;
                cursor:pointer;
            "
        >
            Kirim
        </button>

    </form>

</div>


<script>

const currentUserId = {{ auth()->id() }};

const messagesContainer =
    document.getElementById('messages');

const form =
    document.getElementById('chat-form');

const input =
    document.getElementById('message-input');


let lastMessageId = 0;


// Ambil ID pesan terakhir
const existingMessages =
    document.querySelectorAll('.message');

if (existingMessages.length > 0) {

    lastMessageId =
        Number(
            existingMessages[
                existingMessages.length - 1
            ].dataset.id
        );
}


// Scroll ke bawah
function scrollToBottom()
{
    messagesContainer.scrollTop =
        messagesContainer.scrollHeight;
}


scrollToBottom();


// Escape HTML
function escapeHtml(text)
{
    const div =
        document.createElement('div');

    div.textContent = text;

    return div.innerHTML;
}


// Tambahkan pesan baru
function addMessage(message)
{
    // Jangan tambah kalau sudah ada
    if (
        document.querySelector(
            `.message[data-id="${message.id}"]`
        )
    ) {
        return;
    }

    const isMine =
        message.sender_id === currentUserId;

    const wrapper =
        document.createElement('div');

    wrapper.className = 'message';

    wrapper.dataset.id =
        message.id;

    wrapper.style.marginBottom =
        '12px';

    wrapper.style.textAlign =
        isMine ? 'right' : 'left';

    wrapper.innerHTML = `
        <div
            style="
                display:inline-block;
                max-width:70%;
                padding:10px 14px;
                border-radius:12px;
                background:${isMine
                    ? '#111827'
                    : '#e5e7eb'};
                color:${isMine
                    ? 'white'
                    : 'black'};
            "
        >
            ${escapeHtml(message.message)}
        </div>
    `;

    messagesContainer.appendChild(
        wrapper
    );

    if (message.id > lastMessageId) {
        lastMessageId = message.id;
    }

    scrollToBottom();
}


// Ambil pesan baru
async function fetchMessages()
{
    try {

        const response =
            await fetch(
                "{{ route(
                    'chat.messages',
                    $conversation
                ) }}?after=" +
                lastMessageId
            );

        if (!response.ok) {
            return;
        }

        let data;

        try {
            data = await response.json();
        } catch (parseError) {
            // Bukan JSON valid (mis. HTML error page), skip saja
            console.warn('Response bukan JSON, dilewati.');
            return;
        }

        data.messages.forEach(
            function(message) {
                addMessage(message);
            }
        );

    } catch (error) {

        console.error(
            'Gagal mengambil pesan:',
            error
        );

    }
}


// Kirim pesan
form.addEventListener(
    'submit',
    async function(event) {

        event.preventDefault();

        const message =
            input.value.trim();

        if (!message) {
            return;
        }

        try {

            const response =
                await fetch(
                    "{{ route(
                        'chat.send',
                        $conversation
                    ) }}",
                    {
                        method: 'POST',

                        headers: {
                            'Content-Type':
                                'application/json',

                            'Accept':
                                'application/json',

                            'X-CSRF-TOKEN':
                                document
                                    .querySelector(
                                        'input[name="_token"]'
                                    )
                                    .value
                        },

                        body:
                            JSON.stringify({
                                message: message
                            })
                    }
                );

            let data;

            try {
                data = await response.json();
            } catch (parseError) {
                throw new Error(
                    'Server mengembalikan respons tidak valid (bukan JSON). Cek log Laravel.'
                );
            }

            if (!response.ok) {

                throw new Error(
                    data.message ||
                    'Gagal mengirim pesan.'
                );

            }

            addMessage(
                data.message
            );

            input.value = '';

            input.focus();

        } catch (error) {

            console.error(error);

            alert(
                error.message ||
                'Gagal mengirim pesan.'
            );

        }
    }
);


// POLLING
setInterval(
    fetchMessages,
    2000
);

</script>

@endsection