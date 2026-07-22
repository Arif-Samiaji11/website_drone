<?php

namespace App\Http\Controllers;

use App\Models\PortofolioServisDrone;
use App\Http\Requests\StorePortofolioServisDroneRequest;
use App\Http\Requests\UpdatePortofolioServisDroneRequest;
use Illuminate\Http\Request;

class PortofolioServisDroneController extends Controller
{
    public function index()
    {
        $items = \App\Models\PortofolioServisDrone::latest()->paginate(10);
        return view('admin.portofolio-servis-drone.index', ['items' => $items]);
    
    }

    public function create()
    {
        return view('admin.portofolio-servis-drone.create');
    }

    public function store(StorePortofolioServisDroneRequest $request)
    {
        PortofolioServisDrone::create($request->validated());
        return redirect()->route('admin.portofolio-servis-drone.index')->with('success', 'Data berhasil ditambahkan.');
    }

    public function show(PortofolioServisDrone $portofolioServisDrone)
    {
        return view('admin.portofolio-servis-drone.show', ['portofolio' => $portofolioServisDrone]);
    }

    public function edit(PortofolioServisDrone $portofolioServisDrone)
    {
        return view('admin.portofolio-servis-drone.edit', ['portofolio' => $portofolioServisDrone]);
    }

    public function update(UpdatePortofolioServisDroneRequest $request, PortofolioServisDrone $portofolioServisDrone)
    {
        $portofolioServisDrone->update($request->validated());
        return redirect()->route('admin.portofolio-servis-drone.index')->with('success', 'Data berhasil diupdate.');
    }

    public function destroy(PortofolioServisDrone $portofolioServisDrone)
    {
        $portofolioServisDrone->delete();
        return redirect()->route('admin.portofolio-servis-drone.index')->with('success', 'Data berhasil dihapus.');
    }
}