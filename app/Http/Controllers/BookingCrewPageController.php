<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingCrewRequest;
use App\Models\AdminDaftarLayananDarat;
use App\Models\BookingCrew;
use App\Models\PortofolioDarat;
use Illuminate\Http\Request;

class BookingCrewPageController extends Controller
{
    /**
     * Halaman list portofolio + tombol pilih layanan/paket (modal ambil dari DB)
     * GET /booking-photographer-videographer
     */
    public function index()
    {
        $portofolios = PortofolioDarat::latest()->paginate(9);

        // ambil layanan + paket dari DB
        $services = AdminDaftarLayananDarat::query()
            ->where('is_active', true)
            ->with(['paket' => function ($q) {
                $q->where('is_active', true)
                    ->orderBy('sort_order')
                    ->orderBy('id');
            }])
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        return view('pages.booking_crews', compact('portofolios', 'services'));
    }

    /**
     * Halaman form setelah user pilih layanan & paket
     * GET /booking-photographer-videographer/form?layanan=photographer&paket=photo_basic
     */
    public function form(Request $request)
    {
        // ambil query user
        $layanan = (string) $request->query('layanan', '');
        $paket   = (string) $request->query('paket', '');

        // kalau user belum memilih apa pun, defaultkan ke layanan pertama yg aktif
        $defaultService = AdminDaftarLayananDarat::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->first();

        if ($layanan === '' && $defaultService) {
            $layanan = $defaultService->slug;
        }

        // validasi layanan harus ada di DB & aktif
        $service = AdminDaftarLayananDarat::query()
            ->where('is_active', true)
            ->where('slug', $layanan)
            ->with(['paket' => function ($q) {
                $q->where('is_active', true)
                    ->orderBy('sort_order')
                    ->orderBy('id');
            }])
            ->first();

        // kalau layanan tidak valid -> fallback ke default
        if (!$service && $defaultService) {
            $service = AdminDaftarLayananDarat::query()
                ->where('is_active', true)
                ->where('id', $defaultService->id)
                ->with(['paket' => function ($q) {
                    $q->where('is_active', true)
                        ->orderBy('sort_order')
                        ->orderBy('id');
                }])
                ->first();

            $layanan = $service?->slug ?? '';
        }

        // validasi paket harus termasuk paket milik layanan tsb
        $allowedPaket = collect($service?->paket ?? [])->pluck('kode')->all();
        if ($paket !== '' && !in_array($paket, $allowedPaket, true)) {
            $paket = '';
        }

        return view('pages.booking_crews_form', compact('layanan', 'paket'));
    }

    /**
     * Submit form booking -> simpan ke booking_crews
     * POST /booking-photographer-videographer
     */
    public function store(StoreBookingCrewRequest $request)
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

        BookingCrew::create($data);

        return redirect()->route('booking.crews')
            ->with('success', 'Permintaan berhasil dikirim. Tim kami akan menghubungi kamu.');
    }
}
