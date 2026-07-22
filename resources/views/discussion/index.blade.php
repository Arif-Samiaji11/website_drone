<x-app-layout>
  <x-slot name="header">
    <div class="flex items-center justify-between">
      <h2 class="font-semibold text-xl text-white leading-tight">
        {{ $discussion->service_label }}
      </h2>
    </div>
  </x-slot>

  <!-- Google Fonts & FontAwesome -->
  <link href="https://fonts.googleapis.com/css2?family=Play:wght@400;700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}" type="text/css">

  <!-- Style Khusus Tema Slate-Blue / Navy Cinematic -->
  <style>
    .vg-theme {
      font-family: 'Play', sans-serif;
      background-color: #1a2035;
      color: #fff;
    }
    
    .vg-chat-card {
      background: #202940;
      border: 1px solid rgba(255, 255, 255, 0.08);
      border-radius: 20px;
      box-shadow: 0 12px 30px rgba(0, 0, 0, 0.25);
      display: flex;
      flex-direction: column;
      height: 600px;
    }

    .vg-chat-history {
      flex: 1;
      overflow-y: auto;
      padding: 24px;
      display: flex;
      flex-direction: column;
      gap: 16px;
    }

    /* Scrollbar Style */
    .vg-chat-history::-webkit-scrollbar {
      width: 6px;
    }
    .vg-chat-history::-webkit-scrollbar-track {
      background: rgba(255, 255, 255, 0.02);
    }
    .vg-chat-history::-webkit-scrollbar-thumb {
      background: rgba(255, 255, 255, 0.15);
      border-radius: 99px;
    }

    /* Message Bubbles */
    .vg-bubble {
      max-width: 75%;
      padding: 14px 18px;
      border-radius: 18px;
      line-height: 1.5;
      font-family: "Josefin Sans", sans-serif;
      font-size: 15px;
    }

    /* Sent by User (Right) */
    .vg-bubble-user {
      align-self: flex-end;
      background: linear-gradient(135deg, #181d30 0%, #151a2e 100%);
      border: 1px solid rgba(0, 199, 255, 0.35);
      color: #fff;
      border-bottom-right-radius: 4px;
      box-shadow: 0 4px 15px rgba(0, 199, 255, 0.08);
    }

    /* Sent by Admin (Left) */
    .vg-bubble-admin {
      align-self: flex-start;
      background: linear-gradient(135deg, #e53637 0%, #b22425 100%);
      border: 1px solid rgba(229, 54, 55, 0.2);
      color: #fff;
      border-bottom-left-radius: 4px;
      box-shadow: 0 4px 15px rgba(229, 54, 55, 0.15);
    }

    /* Input Field */
    .vg-input-group {
      border-top: 1px solid rgba(255, 255, 255, 0.08);
      padding: 16px 24px;
      display: flex;
      gap: 12px;
      align-items: center;
      background: rgba(0, 0, 0, 0.15);
      border-bottom-left-radius: 20px;
      border-bottom-right-radius: 20px;
    }

    .vg-chat-input {
      flex: 1;
      background-color: #151a30;
      border: 1px solid rgba(255, 255, 255, 0.12);
      color: #ffffff;
      border-radius: 999px;
      padding: 12px 20px;
      outline: none;
      transition: all 0.25s ease;
      font-family: "Josefin Sans", sans-serif;
      font-size: 14px;
    }

    .vg-chat-input:focus {
      border-color: #00c7ff;
      box-shadow: 0 0 10px rgba(0, 199, 255, 0.35);
      background-color: #171d37;
    }

    .vg-btn-send {
      background: #e53637;
      border: 1px solid #e53637;
      border-radius: 50%;
      width: 48px;
      height: 48px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #fff;
      font-size: 16px;
      cursor: pointer;
      transition: all 0.25s ease;
    }

    .vg-btn-send:hover {
      background: transparent;
      color: #e53637 !important;
      border-color: #e53637;
      transform: scale(1.05);
    }
  </style>

  <!-- Area Konten Utama (Slate-Blue / Navy Theme) -->
  <div class="py-12 vg-theme min-h-[calc(100vh-12rem)]">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
      
      <!-- Header Area -->
      <div class="mb-8 flex justify-between items-center">
        <div>
          <h1 class="text-2xl font-bold tracking-tight text-white uppercase" style="letter-spacing: 1px;">Ruang Diskusi</h1>
          <p class="text-[#00c7ff] text-xs mt-1" style="font-family: 'Josefin Sans', sans-serif; font-weight: 600;">
            Kategori: {{ $discussion->service_label }}
          </p>
        </div>
        <a href="{{ route('diskusi.index') }}" class="text-xs uppercase tracking-widest text-[#00c7ff] hover:underline" style="font-family: 'Josefin Sans', sans-serif; font-weight: 600;">
          <i class="fa fa-arrow-left mr-1"></i> Kembali ke Menu
        </a>
      </div>

      <!-- Chat Container Card -->
      <div class="vg-chat-card">
        
        <!-- Chat History Area -->
        <div class="vg-chat-history" id="chat-history">
          <!-- Welcome Message -->
          <div class="vg-bubble vg-bubble-admin">
            <div class="font-bold text-xs mb-1" style="font-family: 'Play', sans-serif; opacity: 0.8;">Admin Mriki_Project</div>
            Halo {{ auth()->user()->name }}! Selamat datang di menu diskusi kategori <strong>{{ $discussion->service_label }}</strong>. Ada yang bisa kami bantu?
          </div>

          <!-- Conversation Loop -->
          @foreach($discussion->messages as $msg)
            @php
              $isUser = ($msg->sender_id === auth()->id());
            @endphp
            <div class="vg-bubble {{ $isUser ? 'vg-bubble-user' : 'vg-bubble-admin' }}">
              <div class="font-bold text-xs mb-1" style="font-family: 'Play', sans-serif; opacity: 0.8;">
                {{ $isUser ? 'Kamu' : $msg->sender->name }}
              </div>
              <div class="whitespace-pre-wrap">{{ $msg->message }}</div>
              <div class="text-[9px] text-white/40 text-right mt-1.5" style="font-family: 'Josefin Sans', sans-serif;">
                {{ $msg->created_at->format('H:i') }}
              </div>
            </div>
          @endforeach
        </div>

        <!-- Chat Input Form -->
        <form method="POST" action="{{ route('diskusi.send', $service_type) }}" class="vg-input-group">
          @csrf
          <input type="text" name="message" class="vg-chat-input" placeholder="Tulis pesan diskusi di sini..." required autocomplete="off">
          <button type="submit" class="vg-btn-send" title="Kirim Pesan">
            <i class="fa fa-paper-plane"></i>
          </button>
        </form>

      </div>

    </div>
  </div>

  <!-- Auto scroll to bottom & Real-time Polling -->
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const chatHistory = document.getElementById("chat-history");
      if (chatHistory) {
        chatHistory.scrollTop = chatHistory.scrollHeight;
      }

      let messageCount = {{ $discussion->messages->count() }};

      function fetchMessages() {
        fetch("{{ route('diskusi.messages', $service_type) }}")
          .then(res => res.json())
          .then(data => {
            const messages = data.messages;
            if (messages.length !== messageCount) {
              messageCount = messages.length;
              
              // Re-render
              let html = `
                <div class="vg-bubble vg-bubble-admin">
                  <div class="font-bold text-xs mb-1" style="font-family: 'Play', sans-serif; opacity: 0.8;">Admin Mriki_Project</div>
                  Halo {{ auth()->user()->name }}! Selamat datang di menu diskusi kategori <strong>{{ $discussion->service_label }}</strong>. Ada yang bisa kami bantu?
                </div>
              `;
              
              messages.forEach(msg => {
                const bubbleClass = msg.is_user ? 'vg-bubble-user' : 'vg-bubble-admin';
                const senderName = msg.is_user ? 'Kamu' : msg.sender_name;
                html += `
                  <div class="vg-bubble ${bubbleClass}">
                    <div class="font-bold text-xs mb-1" style="font-family: 'Play', sans-serif; opacity: 0.8;">
                      ${senderName}
                    </div>
                    <div class="whitespace-pre-wrap">${escapeHtml(msg.message)}</div>
                    <div class="text-[9px] text-white/40 text-right mt-1.5" style="font-family: 'Josefin Sans', sans-serif;">
                      ${msg.time}
                    </div>
                  </div>
                `;
              });
              
              chatHistory.innerHTML = html;
              chatHistory.scrollTop = chatHistory.scrollHeight;
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

      // Check messages every 3 seconds
      setInterval(fetchMessages, 3000);
    });
  </script>
</x-app-layout>
