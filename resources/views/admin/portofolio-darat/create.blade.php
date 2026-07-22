@extends('layouts.admin')

@section('title', 'Kelola Portofolio Jasa Darat - Tambah')

@section('content')
<div class="w-full px-4 md:px-8 py-4">

  <div class="mb-4 flex items-center justify-between">
    <a href="{{ route('admin.portofolio-darat.index') }}" class="text-sm text-slate-600 hover:underline">← Kembali</a>
    <div class="text-xs text-slate-500">Tambah Portofolio Jasa Darat</div>
  </div>

  <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 w-full">
    <div class="flex items-start justify-between gap-4 mb-4">
      <div>
        <h1 class="text-2xl font-extrabold text-slate-900">
          Kelola Portofolio Jasa Darat
        </h1>
        <p class="text-sm text-slate-500 mt-1">Isi data, upload cover untuk thumbnail, dan tambahkan link YouTube jika ada video.</p>
      </div>
    </div>

    @if($errors->any())
      <div class="mb-4 p-3 rounded-xl bg-red-50 border border-red-200 text-red-800">
        <ul class="list-disc pl-5">
          @foreach($errors->all() as $e)
            <li>{{ $e }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    {{-- FULL SCREEN LANDSCAPE: 2 kolom (Form + Preview) --}}
    <div class="grid lg:grid-cols-2 gap-6">

      {{-- KIRI: FORM --}}
      <div>
        {{-- WAJIB enctype karena upload foto --}}
        <form method="POST"
              action="{{ route('admin.portofolio-darat.store') }}"
              enctype="multipart/form-data"
              class="space-y-4"
              id="portofolioForm">
          @csrf

          <div>
            <label class="text-sm font-semibold text-slate-700">Judul</label>
            <input name="judul"
                   value="{{ old('judul') }}"
                   placeholder="Contoh: WCC - Cinematic"
                   class="mt-1 w-full px-3 py-2 rounded-xl border border-slate-200
                          focus:outline-none focus:ring-2 focus:ring-red-200">
          </div>

          <div>
            <label class="text-sm font-semibold text-slate-700">Deskripsi</label>
            <textarea name="deskripsi" rows="5"
                      placeholder="Tulis deskripsi portofolio..."
                      class="mt-1 w-full px-3 py-2 rounded-xl border border-slate-200
                             focus:outline-none focus:ring-2 focus:ring-red-200">{{ old('deskripsi') }}</textarea>
          </div>

          <div class="grid md:grid-cols-2 gap-4">
            <div>
              <label class="text-sm font-semibold text-slate-700">Lokasi</label>
              <input name="lokasi"
                     value="{{ old('lokasi') }}"
                     placeholder="Contoh: Semingkir"
                     class="mt-1 w-full px-3 py-2 rounded-xl border border-slate-200
                            focus:outline-none focus:ring-2 focus:ring-red-200">
            </div>

            <div>
              <label class="text-sm font-semibold text-slate-700">Tanggal</label>
              <input type="date"
                     name="tanggal"
                     value="{{ old('tanggal') }}"
                     class="mt-1 w-full px-3 py-2 rounded-xl border border-slate-200
                            focus:outline-none focus:ring-2 focus:ring-red-200">
            </div>
          </div>

          {{-- VIDEO: YouTube link (support watch, youtu.be, shorts, live, embed, music.youtube.com) --}}
          <div>
            <label class="text-sm font-semibold text-slate-700">Link YouTube (Video)</label>
            <input name="youtube_url"
                   id="youtube_url"
                   value="{{ old('youtube_url') }}"
                   placeholder="Tempel link YouTube apa pun (watch/shorts/live/youtu.be)"
                   class="mt-1 w-full px-3 py-2 rounded-xl border border-slate-200
                          focus:outline-none focus:ring-2 focus:ring-red-200">
            <p class="text-xs text-slate-500 mt-1">
              Contoh: https://youtu.be/VIDEOID atau https://www.youtube.com/shorts/VIDEOID
            </p>
            <p id="yt_hint" class="text-xs mt-1 hidden"></p>
          </div>

          {{-- COVER: upload foto SAJA --}}
          <div>
            <label class="text-sm font-semibold text-slate-700">Cover / Thumbnail (Foto)</label>
            <input type="file"
                   name="cover"
                   id="cover"
                   accept="image/*"
                   class="mt-1 w-full px-3 py-2 rounded-xl border border-slate-200">
            <p class="text-xs text-slate-500 mt-1">Upload foto thumbnail (jpg / png / webp).</p>
          </div>

          <div class="flex gap-2 pt-2">
            <button class="px-4 py-2 rounded-xl bg-red-600 text-white font-semibold hover:bg-red-500 transition shadow-sm">
              Simpan
            </button>
            <a href="{{ route('admin.portofolio-darat.index') }}"
               class="px-4 py-2 rounded-xl bg-slate-100 text-slate-700 font-semibold hover:bg-slate-200 transition">
              Batal
            </a>
          </div>
        </form>
      </div>

      {{-- KANAN: PREVIEW (Landscape) --}}
      <div class="lg:sticky lg:top-4 h-fit">
        <div class="rounded-2xl border border-slate-200 bg-slate-50 overflow-hidden">
          <div class="p-4 border-b border-slate-200 bg-white">
            <div class="text-sm font-bold text-slate-900">Preview</div>
            <div class="text-xs text-slate-500">Cek thumbnail & video sebelum simpan</div>
          </div>

          <div class="p-4 space-y-4">
            {{-- Preview Cover --}}
            <div>
              <div class="text-xs font-semibold text-slate-600 mb-2">Thumbnail</div>
              <div class="rounded-xl overflow-hidden border border-slate-200 bg-white">
                <img id="cover_preview"
                     src="https://via.placeholder.com/1200x675?text=Thumbnail+Preview"
                     alt="Cover Preview"
                     class="w-full h-[280px] object-cover">
              </div>
              <div class="text-xs text-slate-500 mt-2">Rasio landscape (16:9) disarankan.</div>
            </div>

            {{-- Preview Video --}}
            <div>
              <div class="text-xs font-semibold text-slate-600 mb-2">Video YouTube</div>
              <div class="rounded-xl overflow-hidden border border-slate-200 bg-black">
                <iframe id="yt_iframe"
                        class="w-full aspect-video"
                        src=""
                        title="YouTube preview"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        allowfullscreen>
                </iframe>
              </div>
              <div id="yt_preview_note" class="text-xs text-slate-500 mt-2">
                Tempel link YouTube untuk tampilkan preview di sini.
              </div>
            </div>

            {{-- Info ringkas --}}
            <div class="rounded-xl border border-slate-200 bg-white p-4">
              <div class="text-xs font-semibold text-slate-700">Tips</div>
              <ul class="text-xs text-slate-600 list-disc pl-4 mt-2 space-y-1">
                <li>Gunakan thumbnail landscape (16:9) untuk tampilan rapi.</li>
                <li>Link Shorts/Live juga bisa, yang penting ada ID video.</li>
                <li>Kalau link tidak valid, preview video tidak muncul.</li>
              </ul>
            </div>

          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<script>
  // ==== COVER PREVIEW ====
  const coverInput = document.getElementById('cover');
  const coverPreview = document.getElementById('cover_preview');

  coverInput?.addEventListener('change', (e) => {
    const file = e.target.files?.[0];
    if (!file) return;

    const url = URL.createObjectURL(file);
    coverPreview.src = url;
  });

  // ==== YOUTUBE ID PARSER (support many formats) ====
  const ytInput = document.getElementById('youtube_url');
  const ytIframe = document.getElementById('yt_iframe');
  const ytHint = document.getElementById('yt_hint');
  const ytNote = document.getElementById('yt_preview_note');

  function extractYouTubeId(url) {
    if (!url) return null;
    const s = String(url).trim();

    // If user pastes only ID (11 chars), accept it.
    if (/^[a-zA-Z0-9_-]{11}$/.test(s)) return s;

    // Try to parse as URL
    try {
      const u = new URL(s);

      // youtu.be/VIDEOID
      if (u.hostname.includes('youtu.be')) {
        const id = u.pathname.split('/').filter(Boolean)[0];
        if (id && /^[a-zA-Z0-9_-]{11}$/.test(id)) return id;
      }

      // youtube.com/watch?v=VIDEOID
      const v = u.searchParams.get('v');
      if (v && /^[a-zA-Z0-9_-]{11}$/.test(v)) return v;

      // youtube.com/shorts/VIDEOID
      // youtube.com/embed/VIDEOID
      // youtube.com/live/VIDEOID
      const pathParts = u.pathname.split('/').filter(Boolean);
      const candidates = [];
      for (let i = 0; i < pathParts.length; i++) {
        const part = pathParts[i];
        // shorts/<id>, embed/<id>, live/<id>
        if (['shorts', 'embed', 'live'].includes(part) && pathParts[i + 1]) {
          candidates.push(pathParts[i + 1]);
        }
        // Sometimes the ID can be first segment (rare), keep safe:
        candidates.push(part);
      }

      for (const c of candidates) {
        if (c && /^[a-zA-Z0-9_-]{11}$/.test(c)) return c;
      }

      return null;
    } catch (e) {
      // Not a valid URL and not an ID
      return null;
    }
  }

  function updateYouTubePreview() {
    const raw = ytInput?.value || '';
    const id = extractYouTubeId(raw);

    if (!raw.trim()) {
      ytIframe.src = '';
      ytHint.classList.add('hidden');
      ytNote.textContent = 'Tempel link YouTube untuk tampilkan preview di sini.';
      return;
    }

    if (!id) {
      ytIframe.src = '';
      ytHint.classList.remove('hidden');
      ytHint.className = 'text-xs mt-1 text-red-600';
      ytHint.textContent = 'Link tidak terbaca. Pastikan link YouTube mengandung ID video (11 karakter).';
      ytNote.textContent = 'Preview tidak tersedia karena link belum valid.';
      return;
    }

    // Embed URL
    ytIframe.src = `https://www.youtube.com/embed/${id}`;
    ytHint.classList.remove('hidden');
    ytHint.className = 'text-xs mt-1 text-emerald-600';
    ytHint.textContent = 'Link YouTube valid. Preview ditampilkan.';
    ytNote.textContent = 'Preview video aktif.';
  }

  ytInput?.addEventListener('input', updateYouTubePreview);
  // Init
  updateYouTubePreview();
</script>
@endsection
