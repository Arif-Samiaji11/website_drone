@extends('layouts.admin')

@section('title', 'Kelola Portofolio Jasa Servis Drone - Tambah')

@section('content')
<div class="mb-4">
  <a href="{{ route('admin.portofolio-servis-drone.index') }}" class="text-sm text-slate-600 hover:underline">← Kembali</a>
</div>

<div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 max-w-3xl">
  <h1 class="text-xl font-extrabold text-slate-900 mb-4">Kelola Portofolio Jasa Servis Drone - Tambah</h1>

  @if($errors->any())
    <div class="mb-4 p-3 rounded-xl bg-red-50 border border-red-200 text-red-800">
      <ul class="list-disc pl-5">
        @foreach($errors->all() as $e)
          <li>{{ $e }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form method="POST" action="{{ route('admin.portofolio-servis-drone.store') }}" class="space-y-4">
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
      <input name="cover" value="{{ old('cover') }}"
             class="mt-1 w-full px-3 py-2 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-red-200">
      <p class="text-xs text-slate-500 mt-1">Nanti bisa kamu ganti jadi upload file kalau mau.</p>
    </div>

    <div class="flex gap-2">
      <button class="px-4 py-2 rounded-xl bg-red-600 text-white font-semibold hover:bg-red-500 transition shadow-sm">
        Simpan
      </button>
      <a href="{{ route('admin.portofolio-servis-drone.index') }}"
         class="px-4 py-2 rounded-xl bg-slate-100 text-slate-700 font-semibold hover:bg-slate-200 transition">
        Batal
      </a>
    </div>
  </form>
</div>
@endsection