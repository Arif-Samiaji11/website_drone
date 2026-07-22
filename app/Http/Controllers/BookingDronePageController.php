<?php

namespace App\Http\Controllers;

use App\Models\PortofolioUdara;
use App\Models\BookingDrone;
use App\Http\Requests\StoreBookingDroneRequest;
use Illuminate\Http\Request;

class BookingDronePageController extends Controller
{
    public function index()
    {
        $portofolios = PortofolioUdara::latest()->paginate(9);
        $allPortofolios = PortofolioUdara::all();
        return view('pages.booking_drone', compact('portofolios', 'allPortofolios'));
    }

    // Kalau drone juga punya halaman form terpisah:
    public function form(Request $request)
    {
        $paket = $request->query('paket', '');

        // contoh validasi paket drone (sesuaikan list kamu)
        $allowedPaket = ['drone_basic', 'drone_standard', 'drone_premium'];
        if ($paket && !in_array($paket, $allowedPaket, true)) {
            $paket = '';
        }

        return view('pages.booking_drone_form', compact('paket'));
    }

    public function store(StoreBookingDroneRequest $request)
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

        BookingDrone::create($data);

        return redirect()->route('booking.drone')
            ->with('success', 'Permintaan berhasil dikirim. Tim kami akan menghubungi kamu.');
    }
}
