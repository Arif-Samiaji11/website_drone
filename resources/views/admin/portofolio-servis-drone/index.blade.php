@extends('layouts.admin')

@section('title', 'Kelola Portofolio Jasa Servis Drone')

@section('content')
<div class="flex items-center justify-between mb-4">
  <div>
    <h1 class="text-xl font-extrabold text-slate-900">Kelola Portofolio Jasa Servis Drone</h1>
    <p class="text-sm text-slate-500">Servis & perbaikan drone</p>
  </div>
  <a href="{{ route('admin.portofolio-servis-drone.create') }}"
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
        <th class="text-left p-3">Judul</th>
        <th class="text-left p-3">Lokasi</th>
        <th class="text-left p-3">Tanggal</th>
        <th class="text-right p-3">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($items as $item)
      <tr class="border-t border-slate-100">
        <td class="p-3 font-semibold text-slate-800">{{ $item->judul }}</td>
        <td class="p-3 text-slate-600">{{ $item->lokasi }}</td>
        <td class="p-3 text-slate-600">{{ $item->tanggal }}</td>
        <td class="p-3">
          <div class="flex justify-end gap-2">
            <a class="px-3 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 transition"
               href="{{ route('admin.portofolio-servis-drone.show', $item) }}">Detail</a>
            <a class="px-3 py-1.5 rounded-lg bg-amber-100 hover:bg-amber-200 transition"
               href="{{ route('admin.portofolio-servis-drone.edit', $item) }}">Edit</a>
            <form method="POST" action="{{ route('admin.portofolio-servis-drone.destroy', $item) }}"
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
        <td colspan="4" class="p-6 text-center text-slate-500">Belum ada data.</td>
      </tr>
      @endforelse
    </tbody>
  </table>
</div>

<div class="mt-4">
  {{ $items->links() }}
</div>
@endsection