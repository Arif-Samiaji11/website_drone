<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Edit Paket Layanan Darat</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-900">
  <div class="max-w-2xl mx-auto px-4 py-8">
    <div class="flex items-center justify-between">
      <h1 class="text-2xl font-extrabold">Edit Paket</h1>
      <a href="{{ route('admin.paket-layanan-darat.index') }}" class="font-semibold text-red-600">← Kembali</a>
    </div>

    <div class="mt-6 bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
      <form method="POST" action="{{ route('admin.paket-layanan-darat.update', $item->id) }}" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
          <label class="text-sm font-semibold">Pilih Layanan Utama (Kategori Induk)</label>
          <select name="layanan_id" class="mt-1 w-full px-3 py-2 rounded-xl border border-slate-200">
            @foreach($layananList as $l)
              <option value="{{ $l->id }}" @selected(old('layanan_id', $item->layanan_id) == $l->id)>{{ $l->nama }}</option>
            @endforeach
          </select>
          @error('layanan_id') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
        </div>

        <div>
          <label class="text-sm font-semibold">Kode Paket Unik (Contoh: video_premium, photo_basic)</label>
          <input name="kode" value="{{ old('kode', $item->kode) }}"
                 class="mt-1 w-full px-3 py-2 rounded-xl border border-slate-200"
                 placeholder="Gunakan huruf kecil dan garis bawah, misal: video_premium">
          @error('kode') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
        </div>

        <div>
          <label class="text-sm font-semibold">Nama Paket (Contoh: Paket Premium, Paket Basic)</label>
          <input name="nama" value="{{ old('nama', $item->nama) }}"
                 class="mt-1 w-full px-3 py-2 rounded-xl border border-slate-200"
                 placeholder="Masukkan nama paket">
          @error('nama') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
        </div>

        <div>
          <label class="text-sm font-semibold">Deskripsi Paket (Rincian penawaran / detail layanan)</label>
          <textarea name="deskripsi" rows="4"
                    class="mt-1 w-full px-3 py-2 rounded-xl border border-slate-200"
                    placeholder="Contoh: Durasi 3 Jam, File Master JPG/PNG, 1 Crew Photographer...">{{ old('deskripsi', $item->deskripsi) }}</textarea>
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
            <label class="text-sm font-semibold">Aktif (Tampilkan paket ini di website)</label>
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
