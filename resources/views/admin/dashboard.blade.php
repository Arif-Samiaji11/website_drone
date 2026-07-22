@extends('layouts.admin')

@section('title','Dashboard Admin')

@section('content')
  <h1 class="text-2xl font-bold">Dashboard</h1>
  <p class="mt-2 text-white/80">Selamat datang, {{ auth()->user()->name }}.</p>
@endsection