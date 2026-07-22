@extends('layouts.admin')

@section('title', 'Kelola Diskusi User - Admin')

@section('content')
<div class="max-w-6xl mx-auto">
  <div class="mb-6 flex justify-between items-center">
    <div>
      <h1 class="text-2xl font-extrabold text-slate-800 tracking-tight">Kelola Diskusi User</h1>
      <p class="text-sm text-slate-500 mt-1">Daftar percakapan aktif dengan seluruh client Mriki_Project.</p>
    </div>
  </div>

  @if(session('success'))
    <div class="mb-6 p-4 rounded-xl bg-green-50 border border-green-200 text-green-800 font-medium">
      {{ session('success') }}
    </div>
  @endif

  <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse">
        <thead>
          <tr class="bg-slate-50/75 border-b border-slate-200 text-slate-600 font-semibold text-xs uppercase tracking-wider">
            <th class="px-6 py-4">Client</th>
            <th class="px-6 py-4">Topik</th>
            <th class="px-6 py-4">Pesan Terakhir</th>
            <th class="px-6 py-4">Update Terakhir</th>
            <th class="px-6 py-4 text-right">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100 text-sm">
          @forelse($discussions as $d)
            @php
              $lastMessage = $d->messages()->latest()->first();
            @endphp
            <tr class="hover:bg-slate-50/50 transition">
              <td class="px-6 py-4">
                <div class="flex items-center">
                  <div class="font-bold text-slate-900">{{ $d->user->name ?? 'Guest' }}</div>
                  @php
                    $unreadCount = $d->messages()->where('sender_id', '!=', auth()->id())->where('is_read', false)->count();
                  @endphp
                  <span class="row-unread-badge bg-red-600 text-white text-[10px] font-extrabold px-2 py-0.5 rounded-full ml-2 shadow-sm"
                        data-id="{{ $d->id }}"
                        style="{{ $unreadCount > 0 ? '' : 'display: none;' }}">
                    {{ $unreadCount }}
                  </span>
                </div>
                <div class="text-xs text-slate-500 mt-0.5">{{ $d->user->email ?? '-' }}</div>
              </td>
              <td class="px-6 py-4 text-slate-700 font-medium">
                @php
                  $badgeColors = match($d->service_type) {
                    'booking_drone' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                    'booking_crews' => 'bg-sky-100 text-sky-800 border-sky-200',
                    'servis_drone' => 'bg-rose-100 text-rose-800 border-rose-200',
                    'order_drone' => 'bg-amber-100 text-amber-800 border-amber-200',
                    default => 'bg-slate-100 text-slate-800 border-slate-200',
                  };
                @endphp
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold border {{ $badgeColors }}">
                  {{ $d->service_label }}
                </span>
              </td>
              <td class="px-6 py-4 text-slate-500 max-w-xs truncate row-last-message" data-id="{{ $d->id }}">
                {{ $lastMessage ? $lastMessage->message : '(Belum ada pesan)' }}
              </td>
              <td class="px-6 py-4 text-slate-500 text-xs row-updated-at" data-id="{{ $d->id }}">
                {{ $d->updated_at->diffForHumans() }}
              </td>
              <td class="px-6 py-4 text-right">
                <a href="{{ route('admin.diskusi.show', $d) }}"
                   class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-red-600 hover:bg-red-500 text-white font-semibold text-xs tracking-wide uppercase transition shadow-sm">
                  <svg viewBox="0 0 24 24" class="w-3.5 h-3.5" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                  Buka Chat
                </a>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                <div class="flex flex-col items-center justify-center gap-2">
                  <svg viewBox="0 0 24 24" class="w-10 h-10 text-slate-300" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                  <span class="font-medium">Belum ada diskusi yang masuk.</span>
                </div>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($discussions->hasPages())
      <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
        {{ $discussions->links() }}
      </div>
    @endif
  </div>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      function pollListStatus() {
        fetch("{{ route('admin.diskusi.list-status') }}")
          .then(res => res.json())
          .then(data => {
            data.forEach(item => {
              // Update unread badge
              const badge = document.querySelector(`.row-unread-badge[data-id="${item.id}"]`);
              if (badge) {
                if (item.unread_count > 0) {
                  badge.textContent = item.unread_count;
                  badge.style.display = 'inline-flex';
                } else {
                  badge.style.display = 'none';
                }
              }

              // Update last message
              const lastMsg = document.querySelector(`.row-last-message[data-id="${item.id}"]`);
              if (lastMsg) {
                lastMsg.textContent = item.last_message;
              }

              // Update updated_at
              const updatedAt = document.querySelector(`.row-updated-at[data-id="${item.id}"]`);
              if (updatedAt) {
                updatedAt.textContent = item.updated_at;
              }
            });
          })
          .catch(err => console.error("Error polling list status:", err));
      }

      // Poll every 3.5 seconds
      setInterval(pollListStatus, 3500);
    });
  </script>
</div>
@endsection
