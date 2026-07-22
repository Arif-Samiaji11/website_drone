<?php

namespace App\Http\Controllers;

use App\Models\PortofolioServisDrone;
use App\Models\ServisDrone;
use App\Http\Requests\StoreServisDroneRequest;
use Illuminate\Support\Facades\DB;

class ServisDronePageController extends Controller
{
    public function index()
    {
        // ambil data dari tabel portofolio yang sudah kamu buat
        $portofolios = PortofolioServisDrone::latest()->paginate(9);
        $allPortofolios = PortofolioServisDrone::all();
        return view('pages.servis_drone', compact('portofolios', 'allPortofolios'));
    }

    public function store(StoreServisDroneRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('bukti_pembayaran_dp')) {
            $file = $request->file('bukti_pembayaran_dp');

            $original = $file->getClientOriginalName();
            $safeName = preg_replace('/[^A-Za-z0-9\-\._]/', '-', $original);
            $filename = time() . '-' . $safeName;

            $path = $file->storeAs('bukti_dp', $filename, 'public');
            $data['bukti_pembayaran_dp'] = $path;
        }

        ServisDrone::create($data);

        return redirect()->route('servis.drone')
            ->with('success', 'Permintaan berhasil dikirim. Tim kami akan menghubungi kamu.');
    }
}