@extends('layouts.admin')

@section('title', 'Kelola Portofolio Jasa Udara Drone - Tambah')

@section('content')
<div class="mb-4">
  <a href="{{ route('admin.portofolio-udara.index') }}" class="text-sm text-slate-600 hover:underline">← Kembali</a>
</div>

<div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 max-w-3xl">
  <h1 class="text-xl font-extrabold text-slate-900 mb-4">Kelola Portofolio Jasa Udara Drone - Tambah</h1>

  @if($errors->any())
    <div class="mb-4 p-3 rounded-xl bg-red-50 border border-red-200 text-red-800">
      <ul class="list-disc pl-5">
        @foreach($errors->all() as $e)
          <li>{{ $e }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form method="POST" action="{{ route('admin.portofolio-udara.store') }}" class="space-y-4">
    @csrf
    

    <div>
      <label class="text-sm font-semibold text-slate-700">Judul</label>
      <input name="judul" value="{{ old('judul') }}"
             class="mt-1 w-full px-3 py-2 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-red-200">
    </div>

    <div>
      <label class="text-sm font-semibold text-slate-700">Deskripsi</label>
      <textarea name="deskripsi" rows="4"
                class="mt-1 w-full px-3 py-2 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-red-200">{{ old('deskripsi') }}</textarea>
    </div>

    <div class="grid md:grid-cols-2 gap-4">
      <div>
        <label class="text-sm font-semibold text-slate-700">Lokasi</label>
        <input name="lokasi" value="{{ old('lokasi') }}"
               class="mt-1 w-full px-3 py-2 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-red-200">
      </div>

      <div>
        <label class="text-sm font-semibold text-slate-700">Tanggal</label>
        <input type="date" name="tanggal" value="{{ old('tanggal') }}"
               class="mt-1 w-full px-3 py-2 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-red-200">
      </div>
    </div>

    <div>
      <label class="text-sm font-semibold text-slate-700">Cover (path / url)</label>
      
      <div class="mt-1 bg-slate-50 p-4 rounded-xl border border-slate-200 space-y-3">
        <div class="grid sm:grid-cols-3 gap-3">
          <div>
            <label class="text-xs font-semibold text-slate-500">Tipe Link</label>
            <select id="cover-type-select" class="mt-1 w-full px-3 py-2 rounded-xl border border-slate-200 bg-white focus:outline-none focus:ring-2 focus:ring-red-200 text-sm">
              <option value="youtube">🎥 Video YouTube</option>
              <option value="gdrive">📁 Google Drive (Gambar)</option>
              <option value="direct">🌐 URL / Path Gambar Langsung</option>
            </select>
          </div>
          
          <div class="sm:col-span-2">
            <label class="text-xs font-semibold text-slate-500">Masukkan Link URL</label>
            <input type="text" name="cover" id="cover-url-input" value="{{ old('cover') }}"
                   class="mt-1 w-full px-3 py-2 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-red-200 text-sm"
                   placeholder="Masukkan link cover...">
          </div>
        </div>

        <!-- Warning Message Container -->
        <p id="cover-error-msg" class="text-xs text-red-600 font-semibold hidden"></p>

        <!-- Info Helper Box -->
        <div class="text-[11px] text-slate-500 leading-relaxed bg-white p-3 rounded-lg border border-slate-100">
          <span class="font-bold text-slate-700 block mb-1">Ciri Khas & Ketentuan:</span>
          <ul class="list-disc pl-4 space-y-1">
            <li id="help-youtube"><strong>YouTube</strong>: Harus mengandung <code>youtube.com</code> atau <code>youtu.be</code>. Ini akan memunculkan tombol <em>play video</em> pada portofolio di frontend.</li>
            <li id="help-gdrive" class="hidden"><strong>Google Drive</strong>: Masukkan link shareable biasa, sistem akan otomatis mengubahnya ke format link direct download agar gambar ter-load sempurna.</li>
            <li id="help-direct" class="hidden"><strong>Path Gambar Langsung</strong>: Contoh link gambar langsung (misal: <code>https://domain.com/image.jpg</code>) atau path lokal (misal: <code>img/portfolio/portfolio-1.jpg</code>).</li>
          </ul>
        </div>
      </div>
    </div>

    <script>
      document.addEventListener("DOMContentLoaded", function () {
        const typeSelect = document.getElementById('cover-type-select');
        const urlInput = document.getElementById('cover-url-input');
        const errorMsg = document.getElementById('cover-error-msg');
        const helpYoutube = document.getElementById('help-youtube');
        const helpGdrive = document.getElementById('help-gdrive');
        const helpDirect = document.getElementById('help-direct');

        function updateHelperText(type) {
          helpYoutube.classList.add('hidden');
          helpGdrive.classList.add('hidden');
          helpDirect.classList.add('hidden');
          
          if (type === 'youtube') {
            helpYoutube.classList.remove('hidden');
            urlInput.placeholder = "Contoh: https://www.youtube.com/watch?v=...";
          } else if (type === 'gdrive') {
            helpGdrive.classList.remove('hidden');
            urlInput.placeholder = "Contoh: https://drive.google.com/file/d/.../view";
          } else {
            helpDirect.classList.remove('hidden');
            urlInput.placeholder = "Contoh: https://domain.com/gambar.jpg";
          }
        }

        function processLink() {
          const type = typeSelect.value;
          let url = urlInput.value.trim();
          errorMsg.classList.add('hidden');
          errorMsg.textContent = '';

          if (!url) return;

          if (type === 'gdrive') {
            if (!url.includes('drive.google.com')) {
              errorMsg.textContent = '⚠️ Link harus menyertakan drive.google.com!';
              errorMsg.classList.remove('hidden');
              return;
            }
            const regex1 = /\/file\/d\/([a-zA-Z0-9_-]+)/;
            const regex2 = /[?&]id=([a-zA-Z0-9_-]+)/;
            let match = url.match(regex1);
            if (match && match[1]) {
              urlInput.value = `https://drive.google.com/uc?export=download&id=${match[1]}`;
            } else {
              match = url.match(regex2);
              if (match && match[1]) {
                urlInput.value = `https://drive.google.com/uc?export=download&id=${match[1]}`;
              }
            }
          } else if (type === 'youtube') {
            if (!url.includes('youtube.com') && !url.includes('youtu.be')) {
              errorMsg.textContent = '⚠️ Link video harus menyertakan youtube.com atau youtu.be!';
              errorMsg.classList.remove('hidden');
            }
          }
        }

        // Detect initial type based on value
        const initialUrl = urlInput.value.trim();
        if (initialUrl) {
          if (initialUrl.includes('drive.google.com') || initialUrl.includes('googleusercontent.com')) {
            typeSelect.value = 'gdrive';
          } else if (initialUrl.includes('youtube.com') || initialUrl.includes('youtu.be')) {
            typeSelect.value = 'youtube';
          } else {
            typeSelect.value = 'direct';
          }
        }
        updateHelperText(typeSelect.value);

        typeSelect.addEventListener('change', function () {
          updateHelperText(typeSelect.value);
          processLink();
        });

        urlInput.addEventListener('input', processLink);
        urlInput.addEventListener('change', processLink);
      });
    </script>

    <div class="flex gap-2">
      <button class="px-4 py-2 rounded-xl bg-red-600 text-white font-semibold hover:bg-red-500 transition shadow-sm">
        Simpan
      </button>
      <a href="{{ route('admin.portofolio-udara.index') }}"
         class="px-4 py-2 rounded-xl bg-slate-100 text-slate-700 font-semibold hover:bg-slate-200 transition">
        Batal
      </a>
    </div>
  </form>
</div>
@endsection