<?php

namespace App\Http\Controllers;

use App\Models\PortofolioPenjualan;
use App\Models\OrderDrone;
use App\Http\Requests\StoreOrderDroneRequest;
use Illuminate\Support\Facades\DB;

class OrderDronePageController extends Controller
{
    public function index()
    {
        // ambil data dari tabel portofolio yang sudah kamu buat
        $portofolios = PortofolioPenjualan::latest()->paginate(9);
        $allPortofolios = PortofolioPenjualan::all();
        return view('pages.order_drone', compact('portofolios', 'allPortofolios'));
    }

    public function store(StoreOrderDroneRequest $request)
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

        OrderDrone::create($data);

        return redirect()->route('order.drone')
            ->with('success', 'Permintaan berhasil dikirim. Tim kami akan menghubungi kamu.');
    }
}