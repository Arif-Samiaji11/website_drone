@php use Illuminate\Support\Str; @endphp

@extends('layouts.admin')

@section('title', 'Kelola Portofolio Jasa Darat - Detail')

@section('content')
<div class="w-full px-4 md:px-8 py-4">

  <div class="mb-4 flex items-center justify-between">
    <a href="{{ route('admin.portofolio-darat.index') }}" class="text-sm text-slate-600 hover:underline">← Kembali</a>

    <div class="flex gap-2">
      <a href="{{ route('admin.portofolio-darat.edit', $portofolioDarat->id) }}"
         class="px-3 py-2 rounded-xl bg-slate-100 text-slate-700 text-sm font-semibold hover:bg-slate-200 transition">
        Edit
      </a>

      <form method="POST" action="{{ route('admin.portofolio-darat.destroy', $portofolioDarat->id) }}"
            onsubmit="return confirm('Yakin hapus data ini?')">
        @csrf
        @method('DELETE')
        <button type="submit"
                class="px-3 py-2 rounded-xl bg-red-600 text-white text-sm font-semibold hover:bg-red-500 transition">
          Hapus
        </button>
      </form>
    </div>
  </div>

  <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 w-full">

    <div class="flex items-start justify-between gap-4">
      <div>
        <h1 class="text-2xl font-extrabold text-slate-900 mb-1">
          {{ $portofolioDarat->judul }}
        </h1>

        <div class="text-sm text-slate-500">
          {{ $portofolioDarat->lokasi ?? '-' }}
          <span class="mx-1">·</span>
          {{ $portofolioDarat->tanggal ?? '-' }}
        </div>
      </div>
    </div>

    {{-- Layout landscape --}}
    <div class="grid lg:grid-cols-2 gap-6 mt-6">

      {{-- KIRI: Thumbnail / Cover --}}
      <div>
        <div class="text-xs font-semibold text-slate-600 mb-2">Thumbnail</div>

        <div class="rounded-2xl overflow-hidden border border-slate-200 bg-slate-50">
          @if(!empty($portofolioDarat->cover))
            <img
              src="{{ asset('storage/'.$portofolioDarat->cover) }}"
              alt="Cover"
              class="w-full h-[360px] object-cover"
            >
          @else
            <div class="w-full h-[360px] flex items-center justify-center text-slate-400 text-sm">
              Tidak ada cover
            </div>
          @endif
        </div>

        @if(!empty($portofolioDarat->cover))
          <div class="mt-2 text-xs text-slate-500">
            Path: <span class="font-semibold text-slate-700">{{ $portofolioDarat->cover }}</span>
          </div>
        @endif
      </div>

      {{-- KANAN: Video + Deskripsi --}}
      <div class="space-y-4">

        {{-- Video YouTube --}}
        <div>
          <div class="text-xs font-semibold text-slate-600 mb-2">Video YouTube</div>

          @php
            $raw = trim($portofolioDarat->youtube_url ?? '');
            $youtubeId = null;

            if ($raw !== '') {
              // Jika user input langsung ID 11 char
              if (preg_match('/^[a-zA-Z0-9_-]{11}$/', $raw)) {
                $youtubeId = $raw;
              } else {
                // Ambil ID dari berbagai format:
                // watch?v=ID, youtu.be/ID, shorts/ID, live/ID, embed/ID
                if (preg_match('~(?:v=|\/)([0-9A-Za-z_-]{11})(?:[?&\/]|$)~', $raw, $m)) {
                  $youtubeId = $m[1];
                }
              }
            }
          @endphp

          @if($youtubeId)
            <div class="rounded-2xl overflow-hidden border border-slate-200 bg-black">
              <iframe
                class="w-full aspect-video"
                src="https://www.youtube.com/embed/{{ $youtubeId }}"
                title="YouTube video"
                frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                allowfullscreen>
              </iframe>
            </div>

            <div class="mt-2 text-xs text-slate-500 break-words">
              Link: <a href="{{ $raw }}" target="_blank" class="text-red-600 hover:underline">{{ $raw }}</a>
            </div>
          @elseif($raw !== '')
            <div class="rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
              Link YouTube tidak terbaca. Pastikan link mengandung ID video (11 karakter).
            </div>
            <div class="mt-2 text-xs text-slate-500 break-words">
              Nilai di database: <span class="font-semibold text-slate-700">{{ $raw }}</span>
            </div>
          @else
            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 text-sm text-slate-600">
              Tidak ada video.
            </div>
          @endif
        </div>

        {{-- Deskripsi --}}
        <div>
          <div class="text-xs font-semibold text-slate-600 mb-2">Deskripsi</div>
          <div class="rounded-2xl border border-slate-200 bg-white p-4">
            <p class="text-slate-700 whitespace-pre-line">
              {{ $portofolioDarat->deskripsi ?? '-' }}
            </p>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
@endsection
