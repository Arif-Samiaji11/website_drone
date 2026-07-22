<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Edit Layanan Darat</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-900">
  <div class="max-w-2xl mx-auto px-4 py-8">
    <div class="flex items-center justify-between">
      <h1 class="text-2xl font-extrabold">Edit Layanan</h1>
      <a href="{{ route('admin.layanan-darat.index') }}" class="font-semibold text-red-600">← Kembali</a>
    </div>

    <div class="mt-6 bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
      <form method="POST" action="{{ route('admin.layanan-darat.update', $item->id) }}" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
          <label class="text-sm font-semibold">Nama Layanan (Contoh: Videographer, Photographer)</label>
          <input name="nama" value="{{ old('nama', $item->nama) }}"
                 class="mt-1 w-full px-3 py-2 rounded-xl border border-slate-200"
                 placeholder="Masukkan nama layanan">
          @error('nama') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
        </div>

        <div>
          <label class="text-sm font-semibold">Slug / URL Unik (Contoh: videographer, photographer)</label>
          <input name="slug" value="{{ old('slug', $item->slug) }}"
                 class="mt-1 w-full px-3 py-2 rounded-xl border border-slate-200"
                 placeholder="Gunakan huruf kecil dan tanda hubung, misal: video-darat">
          @error('slug') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
        </div>

        <div class="grid grid-cols-2 gap-3">
          <div>
            <label class="text-sm font-semibold">Urutan Tampilan (Angka terkecil tampil paling atas)</label>
            <input type="number" name="sort_order" value="{{ old('sort_order', $item->sort_order) }}"
                   class="mt-1 w-full px-3 py-2 rounded-xl border border-slate-200">
          </div>
          <div class="flex items-center gap-2 pt-6">
            <input type="checkbox" name="is_active" value="1" class="rounded"
                   @checked(old('is_active', $item->is_active))>
            <label class="text-sm font-semibold">Aktif (Tampilkan layanan ini di website)</label>
          </div>
        </div>

        <button class="w-full px-4 py-2 rounded-xl bg-red-600 text-white font-semibold hover:bg-red-500">
          Update
        </button>
      </form>
    </div>
  </div>
</body>
</html>
