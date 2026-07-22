@extends('layouts.admin')

@section('title', 'Kelola Portofolio Jasa Udara Drone')

@section('content')
<div class="flex items-center justify-between mb-4">
  <div>
    <h1 class="text-xl font-extrabold text-slate-900">Kelola Portofolio Jasa Udara Drone</h1>
    <p class="text-sm text-slate-500">Project jasa udara</p>
  </div>
  <a href="{{ route('admin.portofolio-udara.create') }}"
     class="px-4 py-2 rounded-xl bg-red-600 text-white font-semibold hover:bg-red-500 transition shadow-sm">
    + Tambah
  </a>
</div>

@if(session('success'))
  <div class="mb-4 p-3 rounded-xl bg-green-50 border border-green-200 text-green-800">
    {{ session('success') }}
  </div>
@endif

<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
  <table class="w-full text-sm">
    <thead class="bg-slate-50 text-slate-600">
      <tr>
        <th class="text-left p-3">Cover</th>
        <th class="text-left p-3">Judul</th>
        <th class="text-left p-3">Lokasi</th>
        <th class="text-left p-3">Tanggal</th>
        <th class="text-right p-3">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($items as $item)
      <tr class="border-t border-slate-100">
        <td class="p-3">
          @if($item->cover)
            @php
              $ytId = null;
              if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?|shorts|watch)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/i', $item->cover, $match)) {
                  $ytId = $match[1];
              }
              $isGDrive = str_contains($item->cover, 'drive.google.com') || str_contains($item->cover, 'googleusercontent.com');
            @endphp

            @if($ytId)
              <div class="relative w-20 h-12 rounded overflow-hidden shadow border border-slate-200 bg-slate-900 flex items-center justify-center">
                <img src="https://img.youtube.com/vi/{{ $ytId }}/hqdefault.jpg" class="w-full h-full object-cover">
                <div class="absolute inset-0 flex items-center justify-center bg-black/40">
                  <i class="fa fa-play text-white text-xs"></i>
                </div>
              </div>
            @elseif($isGDrive)
              <div class="flex flex-col gap-1">
                <div class="relative w-20 h-12 rounded overflow-hidden shadow border border-slate-200 bg-slate-100">
                  <img src="{{ $item->cover }}" 
                       onerror="this.style.display='none'; document.getElementById('gdrive-warning-{{ $item->id }}').classList.remove('hidden'); document.getElementById('gdrive-warning-text-{{ $item->id }}').classList.remove('hidden');" 
                       class="w-full h-full object-cover">
                  <div id="gdrive-warning-{{ $item->id }}" class="hidden absolute inset-0 flex items-center justify-center bg-red-50 text-red-600" title="Tolong beri akses link Google Drive Anda">
                    <i class="fa fa-exclamation-triangle text-sm animate-pulse"></i>
                  </div>
                </div>
                <span id="gdrive-warning-text-{{ $item->id }}" class="hidden text-[9px] text-red-600 font-bold leading-tight max-w-[120px]">
                  ⚠️ TOLONG BERI AKSES LINK GOOGLE DRIVE ANDA!
                </span>
              </div>
            @else
              <div class="relative w-20 h-12 rounded overflow-hidden shadow border border-slate-200 bg-slate-100">
                <img src="{{ Str::startsWith($item->cover, ['http://', 'https://']) ? $item->cover : asset($item->cover) }}" 
                     onerror="this.src='{{ asset('img/portfolio/portfolio-1.jpg') }}';"
                     class="w-full h-full object-cover">
              </div>
            @endif
          @else
            <span class="text-xs text-slate-400">Tidak ada</span>
          @endif
        </td>
        <td class="p-3 font-semibold text-slate-800">{{ $item->judul }}</td>
        <td class="p-3 text-slate-600">{{ $item->lokasi }}</td>
        <td class="p-3 text-slate-600">{{ $item->tanggal }}</td>
        <td class="p-3">
          <div class="flex justify-end gap-2">
            <a class="px-3 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 transition"
               href="{{ route('admin.portofolio-udara.show', $item) }}">Detail</a>
            <a class="px-3 py-1.5 rounded-lg bg-amber-100 hover:bg-amber-200 transition"
               href="{{ route('admin.portofolio-udara.edit', $item) }}">Edit</a>
            <form method="POST" action="{{ route('admin.portofolio-udara.destroy', $item) }}"
                  onsubmit="return confirm('Yakin hapus data ini?')">
              @csrf @method('DELETE')
              <button class="px-3 py-1.5 rounded-lg bg-red-100 hover:bg-red-200 transition">
                Hapus
              </button>
            </form>
          </div>
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="5" class="p-6 text-center text-slate-500">Belum ada data.</td>
      </tr>
      @endforelse
    </tbody>
  </table>
</div>

<div class="mt-4">
  {{ $items->links() }}
</div>
@endsection