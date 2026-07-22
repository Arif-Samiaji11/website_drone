<?php

namespace App\Http\Controllers;

use App\Models\PortofolioUdara;
use App\Http\Requests\StorePortofolioUdaraRequest;
use App\Http\Requests\UpdatePortofolioUdaraRequest;
use Illuminate\Http\Request;

class PortofolioUdaraController extends Controller
{
    public function index()
    {
        $items = \App\Models\PortofolioUdara::latest()->paginate(10);
        return view('admin.portofolio-udara.index', ['items' => $items]);
    
    }

    public function create()
    {
        return view('admin.portofolio-udara.create');
    }

    public function store(StorePortofolioUdaraRequest $request)
    {
        PortofolioUdara::create($request->validated());
        return redirect()->route('admin.portofolio-udara.index')->with('success', 'Data berhasil ditambahkan.');
    }

    public function show(PortofolioUdara $portofolioUdara)
    {
        return view('admin.portofolio-udara.show', ['portofolio' => $portofolioUdara]);
    }

    public function edit(PortofolioUdara $portofolioUdara)
    {
        return view('admin.portofolio-udara.edit', ['portofolio' => $portofolioUdara]);
    }

    public function update(UpdatePortofolioUdaraRequest $request, PortofolioUdara $portofolioUdara)
    {
        $portofolioUdara->update($request->validated());
        return redirect()->route('admin.portofolio-udara.index')->with('success', 'Data berhasil diupdate.');
    }

    public function destroy(PortofolioUdara $portofolioUdara)
    {
        $portofolioUdara->delete();
        return redirect()->route('admin.portofolio-udara.index')->with('success', 'Data berhasil dihapus.');
    }
}