@extends('layouts.admin')

@section('title', 'Chat dengan ' . ($discussion->user->name ?? 'Client') . ' - Admin')

@section('content')
<div class="max-w-4xl mx-auto">
  <div class="mb-6 flex justify-between items-center">
    <div>
      <a href="{{ route('admin.diskusi.index') }}" class="text-xs font-bold uppercase tracking-wider text-slate-500 hover:text-slate-800 transition inline-flex items-center gap-1 mb-2">
        <svg viewBox="0 0 24 24" class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
          <line x1="19" y1="12" x2="5" y2="12"></line>
          <polyline points="12 19 5 12 12 5"></polyline>
        </svg>
        Kembali ke Daftar
      </a>
      <h1 class="text-2xl font-extrabold text-slate-800 tracking-tight">Chat: {{ $discussion->user->name ?? 'Client' }}</h1>
      <p class="text-sm text-slate-500 mt-1">E-mail: {{ $discussion->user->email ?? '-' }}</p>
    </div>
  </div>

  @if(session('success'))
    <div class="mb-4 p-3 rounded-xl bg-green-50 border border-green-200 text-green-800 text-sm font-medium">
      {{ session('success') }}
    </div>
  @endif

  <!-- Chat Frame -->
  <div class="bg-white rounded-2xl border border-slate-200 shadow-sm flex flex-col overflow-hidden" style="height: 550px;">
    
    <!-- Chat Area -->
    <div class="flex-1 overflow-y-auto p-6 flex flex-col gap-4 bg-slate-50/50" id="admin-chat-history">
      <!-- Info default -->
      <div class="text-center my-2">
        <span class="px-3 py-1.5 rounded-full bg-slate-100 text-slate-500 text-xs font-medium border border-slate-200/50">
          Awal percakapan dimulai
        </span>
      </div>

      <!-- Messages loop -->
      @foreach($discussion->messages as $msg)
        @php
          $isAdmin = ($msg->sender_id === auth()->id());
        @endphp
        <div class="flex flex-col {{ $isAdmin ? 'items-end' : 'items-start' }}">
          <div class="max-w-lg px-4 py-3 rounded-2xl text-sm leading-relaxed shadow-sm
                      {{ $isAdmin
                          ? 'bg-slate-800 text-white rounded-tr-none'
                          : 'bg-white text-slate-800 border border-slate-200 rounded-tl-none' }}">
            <div class="font-semibold text-xs mb-1 opacity-75">
              {{ $isAdmin ? 'Anda (Admin)' : $msg->sender->name }}
            </div>
            <div class="whitespace-pre-wrap">{{ $msg->message }}</div>
            <div class="text-[9px] text-right mt-1.5 {{ $isAdmin ? 'text-white/50' : 'text-slate-400' }}">
              {{ $msg->created_at->format('d M H:i') }}
            </div>
          </div>
        </div>
      @endforeach
    </div>

    <!-- Reply Input -->
    <form method="POST" action="{{ route('admin.diskusi.send', $discussion) }}" class="p-4 border-t border-slate-200 bg-white flex gap-3 items-center">
      @csrf
      <input type="text" name="message" class="flex-1 px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-red-200 transition" placeholder="Tulis balasan Anda..." required autocomplete="off">
      <button type="submit" class="px-5 py-2.5 rounded-xl bg-red-600 hover:bg-red-500 text-white font-semibold text-sm transition shadow-sm flex items-center gap-1.5">
        Kirim
        <svg viewBox="0 0 24 24" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <line x1="22" y1="2" x2="11" y2="13"></line>
          <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
        </svg>
      </button>
    </form>

  </div>
</div>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    const chatContainer = document.getElementById("admin-chat-history");
    if (chatContainer) {
      chatContainer.scrollTop = chatContainer.scrollHeight;
    }

    let messageCount = {{ $discussion->messages->count() }};

    function fetchAdminMessages() {
      fetch("{{ route('admin.diskusi.messages', $discussion) }}")
        .then(res => res.json())
        .then(data => {
          const messages = data.messages;
          if (messages.length !== messageCount) {
            messageCount = messages.length;

            let html = `
              <div class="text-center my-2">
                <span class="px-3 py-1.5 rounded-full bg-slate-100 text-slate-500 text-xs font-medium border border-slate-200/50">
                  Awal percakapan dimulai
                </span>
              </div>
            `;

            messages.forEach(msg => {
              const alignClass = msg.is_admin ? 'items-end' : 'items-start';
              const bubbleClass = msg.is_admin
                ? 'bg-slate-800 text-white rounded-tr-none'
                : 'bg-white text-slate-800 border border-slate-200 rounded-tl-none';
              const senderLabel = msg.is_admin ? 'Anda (Admin)' : msg.sender_name;
              const dateClass = msg.is_admin ? 'text-white/50' : 'text-slate-400';

              html += `
                <div class="flex flex-col ${alignClass}">
                  <div class="max-w-lg px-4 py-3 rounded-2xl text-sm leading-relaxed shadow-sm ${bubbleClass}">
                    <div class="font-semibold text-xs mb-1 opacity-75">
                      ${senderLabel}
                    </div>
                    <div class="whitespace-pre-wrap">${escapeHtml(msg.message)}</div>
                    <div class="text-[9px] text-right mt-1.5 ${dateClass}">
                      ${msg.time}
                    </div>
                  </div>
                </div>
              `;
            });

            chatContainer.innerHTML = html;
            chatContainer.scrollTop = chatContainer.scrollHeight;
          }
        })
        .catch(err => console.error("Error fetching messages:", err));
    }

    function escapeHtml(str) {
      return str
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
    }

    setInterval(fetchAdminMessages, 3000);
  });
</script>
@endsection
