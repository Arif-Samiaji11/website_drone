@extends('layouts.admin')

@section('title', 'Kelola Portofolio Penjualan - Detail')

@section('content')
<div class="mb-4">
  <a href="{{ route('admin.portofolio-penjualan.index') }}" class="text-sm text-slate-600 hover:underline">← Kembali</a>
</div>

<div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
  <h1 class="text-xl font-extrabold text-slate-900 mb-1">{{ $portofolio->judul }}</h1>
  <div class="text-sm text-slate-500 mb-4">
    {{ $portofolio->lokasi }} · {{ $portofolio->tanggal }}
  </div>

  <div class="prose max-w-none">
    <p class="text-slate-700 whitespace-pre-line">{{ $portofolio->deskripsi }}</p>
  </div>

  @if($portofolio->cover)
    <div class="mt-4 text-sm text-slate-600">
      Cover: <span class="font-semibold">{{ $portofolio->cover }}</span>
    </div>
  @endif
</div>
@endsection