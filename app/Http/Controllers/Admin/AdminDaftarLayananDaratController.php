<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminDaftarLayananDarat;
use Illuminate\Http\Request;

class AdminDaftarLayananDaratController extends Controller
{
    public function index()
    {
        // withCount('paket') agar blade bisa menampilkan jumlah paket
        $layanan = AdminDaftarLayananDarat::withCount('paket')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->paginate(15);

        return view('admin.portofolio-darat.layanan.index', compact('layanan'));
    }

    public function create()
    {
        return view('admin.portofolio-darat.layanan.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'slug' => ['required', 'string', 'max:255', 'unique:admin_daftar_layanan_darat,slug'],
            'nama' => ['required', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        // checkbox: kalau tidak dicentang, field tidak terkirim
        $data['is_active']  = $request->has('is_active');
        $data['sort_order'] = (int)($data['sort_order'] ?? 0);

        AdminDaftarLayananDarat::create($data);

        return redirect()->route('admin.layanan-darat.index')
            ->with('success', 'Layanan berhasil ditambahkan.');
    }

    public function edit(AdminDaftarLayananDarat $layanan_darat)
    {
        return view('admin.portofolio-darat.layanan.edit', [
            'item' => $layanan_darat
        ]);
    }

    public function update(Request $request, AdminDaftarLayananDarat $layanan_darat)
    {
        $data = $request->validate([
            'slug' => ['required', 'string', 'max:255', 'unique:admin_daftar_layanan_darat,slug,' . $layanan_darat->id],
            'nama' => ['required', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $data['is_active']  = $request->has('is_active');
        $data['sort_order'] = (int)($data['sort_order'] ?? 0);

        $layanan_darat->update($data);

        return redirect()->route('admin.layanan-darat.index')
            ->with('success', 'Layanan berhasil diupdate.');
    }

    public function destroy(AdminDaftarLayananDarat $layanan_darat)
    {
        // Catatan: kalau kamu set foreign key ON DELETE CASCADE di paket,
        // maka paket terkait akan ikut terhapus otomatis.
        $layanan_darat->delete();

        return redirect()->route('admin.layanan-darat.index')
            ->with('success', 'Layanan berhasil dihapus.');
    }

    public function show(AdminDaftarLayananDarat $layanan_darat)
    {
        // optional: tidak dipakai
        return redirect()->route('admin.layanan-darat.index');
    }
}
