<?php

namespace App\Http\Controllers;

use App\Models\PortofolioDarat;
use App\Http\Requests\StorePortofolioDaratRequest;
use App\Http\Requests\UpdatePortofolioDaratRequest;

class PortofolioDaratController extends Controller
{
    public function index()
    {
        $items = PortofolioDarat::latest()->paginate(10);
        return view('admin.portofolio-darat.index', ['items' => $items]);
    }

    public function create()
    {
        return view('admin.portofolio-darat.create');
    }

    public function store(StorePortofolioDaratRequest $request)
    {
        $data = $request->validated();

        // Upload cover (thumbnail) -> simpan path ke kolom 'cover'
        if ($request->hasFile('cover')) {
            $file = $request->file('cover');

            // simpan dengan nama asli (tanpa hash) tapi aman
            $original = $file->getClientOriginalName();
            $safeName = preg_replace('/[^A-Za-z0-9\-\._]/', '-', $original);
            $filename = time() . '-' . $safeName;

            $path = $file->storeAs('covers', $filename, 'public');
            $data['cover'] = $path;
        } else {
            $data['cover'] = null;
        }

        PortofolioDarat::create($data);

        return redirect()
            ->route('admin.portofolio-darat.index')
            ->with('success', 'Data berhasil ditambahkan.');
    }

    public function show(PortofolioDarat $portofolioDarat)
    {
        return view('admin.portofolio-darat.show', compact('portofolioDarat'));
    }

    public function edit(PortofolioDarat $portofolioDarat)
    {
        return view('admin.portofolio-darat.edit', compact('portofolioDarat'));
    }

    public function update(UpdatePortofolioDaratRequest $request, PortofolioDarat $portofolioDarat)
    {
        $data = $request->validated();

        // kalau upload cover baru -> replace cover
        if ($request->hasFile('cover')) {
            $file = $request->file('cover');

            $original = $file->getClientOriginalName();
            $safeName = preg_replace('/[^A-Za-z0-9\-\._]/', '-', $original);
            $filename = time() . '-' . $safeName;

            $path = $file->storeAs('covers', $filename, 'public');
            $data['cover'] = $path;
        } else {
            // kalau tidak upload cover baru, jangan overwrite cover lama
            unset($data['cover']);
        }

        $portofolioDarat->update($data);

        return redirect()
            ->route('admin.portofolio-darat.index')
            ->with('success', 'Data berhasil diupdate.');
    }

    public function destroy(PortofolioDarat $portofolioDarat)
    {
        $portofolioDarat->delete();

        return redirect()
            ->route('admin.portofolio-darat.index')
            ->with('success', 'Data berhasil dihapus.');
    }
}
