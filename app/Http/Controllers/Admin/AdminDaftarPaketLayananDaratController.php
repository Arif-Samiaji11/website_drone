<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminDaftarLayananDarat;
use App\Models\AdminDaftarPaketLayananDarat;
use Illuminate\Http\Request;

class AdminDaftarPaketLayananDaratController extends Controller
{
    public function index(Request $request)
    {
        // ✅ Ambil layanan + paket dari RELASI, supaya blade menampilkan paket dari $layanan->paket
        $layanan = AdminDaftarLayananDarat::with(['paket' => function ($q) {
                $q->orderBy('sort_order')->orderBy('id');
            }])
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        // blade melakukan filtering berdasarkan request('layanan_id')
        return view('admin.portofolio-darat.paket.index', compact('layanan'));
    }

    public function create()
    {
        $layananList = AdminDaftarLayananDarat::orderBy('sort_order')->orderBy('id')->get();

        return view('admin.portofolio-darat.paket.create', compact('layananList'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'layanan_id' => ['required', 'exists:admin_daftar_layanan_darat,id'],
            'kode' => ['required', 'string', 'max:255', 'unique:admin_daftar_paket_layanan_darat,kode'],
            'nama' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $data['is_active']  = $request->has('is_active');
        $data['sort_order'] = (int)($data['sort_order'] ?? 0);

        AdminDaftarPaketLayananDarat::create($data);

        return redirect()->route('admin.paket-layanan-darat.index')
            ->with('success', 'Paket berhasil ditambahkan.');
    }

    public function edit(AdminDaftarPaketLayananDarat $paket_layanan_darat)
    {
        $layananList = AdminDaftarLayananDarat::orderBy('sort_order')->orderBy('id')->get();

        return view('admin.portofolio-darat.paket.edit', [
            'item' => $paket_layanan_darat->load('layanan'),
            'layananList' => $layananList,
        ]);
    }

    public function update(Request $request, AdminDaftarPaketLayananDarat $paket_layanan_darat)
    {
        $data = $request->validate([
            'layanan_id' => ['required', 'exists:admin_daftar_layanan_darat,id'],
            'kode' => ['required', 'string', 'max:255', 'unique:admin_daftar_paket_layanan_darat,kode,' . $paket_layanan_darat->id],
            'nama' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $data['is_active']  = $request->has('is_active');
        $data['sort_order'] = (int)($data['sort_order'] ?? 0);

        $paket_layanan_darat->update($data);

        return redirect()->route('admin.paket-layanan-darat.index')
            ->with('success', 'Paket berhasil diupdate.');
    }

    public function destroy(AdminDaftarPaketLayananDarat $paket_layanan_darat)
    {
        $paket_layanan_darat->delete();

        return redirect()->route('admin.paket-layanan-darat.index')
            ->with('success', 'Paket berhasil dihapus.');
    }

    public function show(AdminDaftarPaketLayananDarat $paket_layanan_darat)
    {
        // optional: tidak dipakai
        return redirect()->route('admin.paket-layanan-darat.index');
    }
}
