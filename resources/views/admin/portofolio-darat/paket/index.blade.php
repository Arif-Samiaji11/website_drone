<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Admin - Paket Layanan Darat</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-900">
  <div class="max-w-6xl mx-auto px-4 py-8">
    <div class="flex items-center justify-between">
      <h1 class="text-2xl font-extrabold">Paket Layanan Darat</h1>

      <div class="flex items-center gap-2">
        <a href="{{ route('admin.layanan-darat.index') }}"
           class="px-4 py-2 rounded-xl bg-slate-900 text-white font-semibold hover:bg-slate-800">
          Lihat Layanan
        </a>

        <a href="{{ route('admin.paket-layanan-darat.create') }}"
           class="px-4 py-2 rounded-xl bg-red-600 text-white font-semibold hover:bg-red-500">
          + Tambah Paket
        </a>
      </div>
    </div>

    @if(session('success'))
      <div class="mt-4 p-3 rounded-xl bg-green-50 border border-green-200 text-green-800">
        {{ session('success') }}
      </div>
    @endif

    {{-- FILTER --}}
    <div class="mt-5 bg-white rounded-2xl border border-slate-200 shadow-sm p-4">
      <form method="GET" class="flex gap-2 items-end">
        <div class="flex-1">
          <label class="text-sm font-semibold">Filter Layanan</label>
          <select name="layanan_id" class="mt-1 w-full px-3 py-2 rounded-xl border border-slate-200">
            <option value="">Semua</option>
            @foreach(($layanan ?? collect()) as $l)
              <option value="{{ $l->id }}" @selected(request('layanan_id') == $l->id)>{{ $l->nama }}</option>
            @endforeach
          </select>
        </div>
        <button class="px-4 py-2 rounded-xl bg-slate-900 text-white font-semibold">Filter</button>
      </form>
    </div>

    {{-- LIST (ambil dari relasi layanan->paket) --}}
    <div class="mt-6 bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
      <table class="w-full text-sm">
        <thead class="bg-slate-50 border-b border-slate-200">
          <tr>
            <th class="text-left p-3">Layanan</th>
            <th class="text-left p-3">Kode</th>
            <th class="text-left p-3">Nama</th>
            <th class="text-left p-3">Aktif</th>
            <th class="text-left p-3">Sort</th>
            <th class="text-right p-3">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @php
            $filter = request('layanan_id');
            $rows = 0;
          @endphp

          @forelse(($layanan ?? collect()) as $l)
            @php
              // kalau filter dipilih, tampilkan hanya layanan tersebut
              if ($filter && (string)$l->id !== (string)$filter) {
                $paketItems = collect();
              } else {
                // ✅ INI AMBIL DARI RELASI MODEL: $l->paket()
                $paketItems = collect($l->paket ?? []);
              }
            @endphp

            @foreach($paketItems as $item)
              @php $rows++; @endphp
              <tr class="border-b border-slate-100">
                <td class="p-3 font-semibold">{{ $l->nama }}</td>
                <td class="p-3 text-slate-600">{{ $item->kode }}</td>
                <td class="p-3">{{ $item->nama }}</td>
                <td class="p-3">
                  @if($item->is_active)
                    <span class="px-2 py-1 rounded-lg bg-green-50 border border-green-200 text-green-700 text-xs">AKTIF</span>
                  @else
                    <span class="px-2 py-1 rounded-lg bg-slate-100 border border-slate-200 text-slate-600 text-xs">OFF</span>
                  @endif
                </td>
                <td class="p-3">{{ $item->sort_order }}</td>
                <td class="p-3 text-right">
                  <a href="{{ route('admin.paket-layanan-darat.edit', $item->id) }}"
                     class="px-3 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 font-semibold">
                    Edit
                  </a>

                  <form action="{{ route('admin.paket-layanan-darat.destroy', $item->id) }}"
                        method="POST" class="inline-block"
                        onsubmit="return confirm('Hapus paket ini?')">
                    @csrf
                    @method('DELETE')
                    <button class="px-3 py-2 rounded-xl bg-red-600 hover:bg-red-500 text-white font-semibold">
                      Hapus
                    </button>
                  </form>
                </td>
              </tr>
            @endforeach
          @empty
            @php $rows = 0; @endphp
          @endforelse

          @if($rows === 0)
            <tr>
              <td class="p-6 text-slate-500" colspan="6">Belum ada data paket.</td>
            </tr>
          @endif
        </tbody>
      </table>
    </div>

    {{-- kalau kamu mau pagination paket, itu harus dari query paket di controller.
         versi ini sengaja full dari relasi layanan->paket (tanpa paginate). --}}
  </div>
</body>
</html>
