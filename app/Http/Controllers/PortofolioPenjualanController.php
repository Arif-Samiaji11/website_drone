<?php

namespace App\Http\Controllers;

use App\Models\PortofolioPenjualan;
use App\Http\Requests\StorePortofolioPenjualanRequest;
use App\Http\Requests\UpdatePortofolioPenjualanRequest;
use Illuminate\Http\Request;

class PortofolioPenjualanController extends Controller
{
    public function index()
    {
        $items = \App\Models\PortofolioPenjualan::latest()->paginate(10);
        return view('admin.portofolio-penjualan.index', ['items' => $items]);
    
    }

    public function create()
    {
        return view('admin.portofolio-penjualan.create');
    }

    public function store(StorePortofolioPenjualanRequest $request)
    {
        PortofolioPenjualan::create($request->validated());
        return redirect()->route('admin.portofolio-penjualan.index')->with('success', 'Data berhasil ditambahkan.');
    }

    public function show(PortofolioPenjualan $portofolioPenjualan)
{
    return view('admin.portofolio-penjualan.show', ['portofolio' => $portofolioPenjualan]);
}

public function edit(PortofolioPenjualan $portofolioPenjualan)
{
    return view('admin.portofolio-penjualan.edit', ['portofolio' => $portofolioPenjualan]);
}

    public function update(UpdatePortofolioPenjualanRequest $request, PortofolioPenjualan $portofolioPenjualan)
    {
        $portofolioPenjualan->update($request->validated());
        return redirect()->route('admin.portofolio-penjualan.index')->with('success', 'Data berhasil diupdate.');
    }

    public function destroy(PortofolioPenjualan $portofolioPenjualan)
    {
        $portofolioPenjualan->delete();
        return redirect()->route('admin.portofolio-penjualan.index')->with('success', 'Data berhasil dihapus.');
    }
}