@extends('layouts.app2')

@section('title', 'Bantuan - KosMatch')
@section('page-title', 'Bantuan / Customer Service')

@section('content')

<div style="max-width:700px;margin:0 auto;font-family:Arial;">

    <div style="
        background:white;
        border:1px solid #e5e7eb;
        border-radius:12px;
        display:flex;
        flex-direction:column;
        height:600px;
    ">

        <div id="chat-box" style="
            flex:1;
            overflow-y:auto;
            padding:20px;
            display:flex;
            flex-direction:column;
            gap:12px;
        ">
            <div style="
                background:#eef0ff;
                color:#1f2937;
                padding:12px 16px;
                border-radius:10px;
                max-width:80%;
                align-self:flex-start;
            ">
                Halo! Saya asisten Customer Service KosMatch. Ada yang bisa saya bantu seputar booking atau pembayaran?
            </div>
        </div>

        <form id="chat-form" style="
            display:flex;
            gap:10px;
            padding:16px;
            border-top:1px solid #edf0f5;
        ">
            @csrf
            <input
                type="text"
                id="chat-input"
                placeholder="Tulis pertanyaanmu..."
                autocomplete="off"
                required
                style="
                    flex:1;
                    padding:12px 14px;
                    border:1px solid #d1d5db;
                    border-radius:8px;
                    font-size:14px;
                "
            >
            <button
                type="submit"
                id="chat-send"
                style="
                    background:#4353ff;
                    color:white;
                    border:none;
                    padding:12px 20px;
                    border-radius:8px;
                    cursor:pointer;
                "
            >
                Kirim
            </button>
        </form>

    </div>
</div>

<script>
    const chatBox = document.getElementById('chat-box');
    const chatForm = document.getElementById('chat-form');
    const chatInput = document.getElementById('chat-input');
    const chatSend = document.getElementById('chat-send');

    let history = [];

    function appendMessage(text, role) {
        const bubble = document.createElement('div');
        bubble.textContent = text;
        bubble.style.padding = '12px 16px';
        bubble.style.borderRadius = '10px';
        bubble.style.maxWidth = '80%';

        if (role === 'user') {
            bubble.style.background = '#4353ff';
            bubble.style.color = 'white';
            bubble.style.alignSelf = 'flex-end';
        } else {
            bubble.style.background = '#eef0ff';
            bubble.style.color = '#1f2937';
            bubble.style.alignSelf = 'flex-start';
        }

        chatBox.appendChild(bubble);
        chatBox.scrollTop = chatBox.scrollHeight;
    }

    chatForm.addEventListener('submit', async function (e) {
        e.preventDefault();

        const message = chatInput.value.trim();
        if (!message) return;

        appendMessage(message, 'user');
        chatInput.value = '';
        chatSend.disabled = true;
        chatSend.textContent = '...';

        try {
            const response = await fetch('{{ route('student.support.send') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                },
                body: JSON.stringify({
                    message: message,
                    history: history,
                }),
            });

            const rawText = await response.text();
            const jsonStart = rawText.indexOf('{');

            if (jsonStart === -1) {
                throw new Error('Response tidak mengandung JSON: ' + rawText);
            }

            const cleanJson = rawText.slice(jsonStart);
            const data = JSON.parse(cleanJson);

            appendMessage(data.reply, 'assistant');

            history.push({ role: 'user', content: message });
            history.push({ role: 'assistant', content: data.reply });

        } catch (err) {
            console.error(err);
            appendMessage('Maaf, terjadi kesalahan koneksi.', 'assistant');
        } finally {
            chatSend.disabled = false;
            chatSend.textContent = 'Kirim';
        }
    });
</script>

@endsection