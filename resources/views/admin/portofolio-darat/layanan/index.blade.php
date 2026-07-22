<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Admin - Layanan Darat</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-900">
  <div class="max-w-6xl mx-auto px-4 py-8">
    <div class="flex items-center justify-between">
      <h1 class="text-2xl font-extrabold">Layanan Darat</h1>

      <div class="flex items-center gap-2">
        <a href="{{ route('admin.paket-layanan-darat.index') }}"
           class="px-4 py-2 rounded-xl bg-slate-900 text-white font-semibold hover:bg-slate-800">
          Kelola Paket
        </a>

        <a href="{{ route('admin.layanan-darat.create') }}"
           class="px-4 py-2 rounded-xl bg-red-600 text-white font-semibold hover:bg-red-500">
          + Tambah Layanan
        </a>
      </div>
    </div>

    @if(session('success'))
      <div class="mt-4 p-3 rounded-xl bg-green-50 border border-green-200 text-green-800">
        {{ session('success') }}
      </div>
    @endif

    <div class="mt-6 bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
      <table class="w-full text-sm">
        <thead class="bg-slate-50 border-b border-slate-200">
          <tr>
            <th class="text-left p-3">Nama</th>
            <th class="text-left p-3">Slug</th>
            <th class="text-left p-3">Jumlah Paket</th>
            <th class="text-left p-3">Aktif</th>
            <th class="text-left p-3">Sort</th>
            <th class="text-right p-3">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($layanan as $item)
            <tr class="border-b border-slate-100">
              <td class="p-3 font-semibold">{{ $item->nama }}</td>
              <td class="p-3 text-slate-600">{{ $item->slug }}</td>

              {{-- ambil jumlah paket (bisa dari withCount('paket') atau count($item->paket)) --}}
              <td class="p-3 text-slate-700">
                {{ $item->paket_count ?? (isset($item->paket) ? count($item->paket) : 0) }}
              </td>

              <td class="p-3">
                @if($item->is_active)
                  <span class="px-2 py-1 rounded-lg bg-green-50 border border-green-200 text-green-700 text-xs">AKTIF</span>
                @else
                  <span class="px-2 py-1 rounded-lg bg-slate-100 border border-slate-200 text-slate-600 text-xs">OFF</span>
                @endif
              </td>

              <td class="p-3">{{ $item->sort_order }}</td>

              <td class="p-3 text-right">
                <a href="{{ route('admin.layanan-darat.edit', $item->id) }}"
                   class="px-3 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 font-semibold">
                  Edit
                </a>

                <form action="{{ route('admin.layanan-darat.destroy', $item->id) }}"
                      method="POST" class="inline-block"
                      onsubmit="return confirm('Hapus layanan ini? (paket terkait ikut terhapus)')">
                  @csrf
                  @method('DELETE')
                  <button class="px-3 py-2 rounded-xl bg-red-600 hover:bg-red-500 text-white font-semibold">
                    Hapus
                  </button>
                </form>
              </td>
            </tr>
          @empty
            <tr>
              <td class="p-6 text-slate-500" colspan="6">Belum ada data.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div class="mt-5">
      {{ $layanan->links() }}
    </div>
  </div>
</body>
</html>
