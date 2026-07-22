<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BookingDrone;
use App\Models\BookingCrew;
use App\Models\ServisDrone;
use App\Models\OrderDrone;
use Illuminate\Http\Request;

class AdminBookingOrderController extends Controller
{
    // ==========================================
    // BOOKING DRONE
    // ==========================================
    public function bookingDroneIndex()
    {
        // Status baru dibiarkan dan TIDAK otomatis diubah ke proses saat dibuka
        $bookings = BookingDrone::latest()->paginate(15);
        return view('admin.submissions.booking_drone', compact('bookings'));
    }

    public function bookingDroneDestroy(BookingDrone $bookingDrone)
    {
        $bookingDrone->delete();
        return redirect()->route('admin.booking-drone.index')
            ->with('success', 'Data booking drone berhasil dihapus.');
    }

    // ==========================================
    // BOOKING CREWS
    // ==========================================
    public function bookingCrewIndex()
    {
        // Status baru dibiarkan dan TIDAK otomatis diubah ke proses saat dibuka
        $bookings = BookingCrew::latest()->paginate(15);
        return view('admin.submissions.booking_crew', compact('bookings'));
    }

    public function bookingCrewDestroy(BookingCrew $bookingCrew)
    {
        $bookingCrew->delete();
        return redirect()->route('admin.booking-crews.index')
            ->with('success', 'Data booking crew berhasil dihapus.');
    }

    // ==========================================
    // SERVIS DRONE
    // ==========================================
    public function servisDroneIndex()
    {
        // Status baru dibiarkan dan TIDAK otomatis diubah ke proses saat dibuka
        $servis = ServisDrone::latest()->paginate(15);
        return view('admin.submissions.servis_drone', compact('servis'));
    }

    public function servisDroneDestroy(ServisDrone $servisDrone)
    {
        $servisDrone->delete();
        return redirect()->route('admin.servis-drone.index')
            ->with('success', 'Data permintaan servis drone berhasil dihapus.');
    }

    // ==========================================
    // ORDER DRONE
    // ==========================================
    public function orderDroneIndex()
    {
        // Status baru dibiarkan dan TIDAK otomatis diubah ke proses saat dibuka
        $orders = OrderDrone::latest()->paginate(15);
        return view('admin.submissions.order_drone', compact('orders'));
    }

    public function orderDroneDestroy(OrderDrone $orderDrone)
    {
        $orderDrone->delete();
        return redirect()->route('admin.order-drone.index')
            ->with('success', 'Data permintaan order drone berhasil dihapus.');
    }

    // ==========================================
    // API FOR REAL-TIME SIDEBAR BADGES & NOTIFICATIONS
    // ==========================================
    public function getNewSubmissionsCount()
    {
        $bd = BookingDrone::where('status', 'baru')->orderBy('id', 'desc')->get();
        $bc = BookingCrew::where('status', 'baru')->orderBy('id', 'desc')->get();
        $sd = ServisDrone::where('status', 'baru')->orderBy('id', 'desc')->get();
        $od = OrderDrone::where('status', 'baru')->orderBy('id', 'desc')->get();

        return response()->json([
            'booking_drone' => [
                'count' => $bd->count(),
                'latest' => $bd->first() ? ['id' => $bd->first()->id, 'nama' => $bd->first()->nama] : null
            ],
            'booking_crew' => [
                'count' => $bc->count(),
                'latest' => $bc->first() ? ['id' => $bc->first()->id, 'nama' => $bc->first()->nama] : null
            ],
            'servis_drone' => [
                'count' => $sd->count(),
                'latest' => $sd->first() ? ['id' => $sd->first()->id, 'nama' => $sd->first()->nama] : null
            ],
            'order_drone' => [
                'count' => $od->count(),
                'latest' => $od->first() ? ['id' => $od->first()->id, 'nama' => $od->first()->nama] : null
            ],
        ]);
    }

    public function fetchNew(Request $request)
    {
        $type = $request->get('type');
        $lastId = intval($request->get('last_id', 0));

        if (!$type || $lastId <= 0) {
            return response()->json(['html' => '', 'last_id' => $lastId]);
        }

        $html = '';
        $newLastId = $lastId;
        $newItems = [];

        switch ($type) {
            case 'booking_drone':
                $items = BookingDrone::where('id', '>', $lastId)->orderBy('id', 'asc')->get();
                if ($items->isNotEmpty()) {
                    $newLastId = $items->last()->id;
                    foreach ($items as $b) {
                        $html .= view('admin.submissions.partials.booking_drone_row', compact('b'))->render();
                        $newItems[] = ['nama' => $b->nama, 'desc' => 'Booking Jasa Drone dari ' . $b->nama];
                    }
                }
                break;

            case 'booking_crew':
                $items = BookingCrew::where('id', '>', $lastId)->orderBy('id', 'asc')->get();
                if ($items->isNotEmpty()) {
                    $newLastId = $items->last()->id;
                    foreach ($items as $b) {
                        $html .= view('admin.submissions.partials.booking_crew_row', compact('b'))->render();
                        $newItems[] = ['nama' => $b->nama, 'desc' => 'Booking Crews dari ' . $b->nama];
                    }
                }
                break;

            case 'servis_drone':
                $items = ServisDrone::where('id', '>', $lastId)->orderBy('id', 'asc')->get();
                if ($items->isNotEmpty()) {
                    $newLastId = $items->last()->id;
                    foreach ($items as $s) {
                        $html .= view('admin.submissions.partials.servis_drone_row', compact('s'))->render();
                        $newItems[] = ['nama' => $s->nama, 'desc' => 'Servis Drone dari ' . $s->nama];
                    }
                }
                break;

            case 'order_drone':
                $items = OrderDrone::where('id', '>', $lastId)->orderBy('id', 'asc')->get();
                if ($items->isNotEmpty()) {
                    $newLastId = $items->last()->id;
                    foreach ($items as $o) {
                        $html .= view('admin.submissions.partials.order_drone_row', compact('o'))->render();
                        $newItems[] = ['nama' => $o->nama, 'desc' => 'Order Drone dari ' . $o->nama];
                    }
                }
                break;
        }

        return response()->json([
            'html' => $html,
            'last_id' => $newLastId,
            'new_items' => $newItems
        ]);
    }

    public function prosesSubmission(Request $request)
    {
        $type = $request->input('type');
        $id = $request->input('id');

        switch ($type) {
            case 'booking_drone':
                $item = BookingDrone::findOrFail($id);
                break;
            case 'booking_crew':
                $item = BookingCrew::findOrFail($id);
                break;
            case 'order_drone':
                $item = OrderDrone::findOrFail($id);
                break;
            case 'servis_drone':
                $item = ServisDrone::findOrFail($id);
                break;
            default:
                return response()->json(['success' => false, 'message' => 'Tipe pengajuan tidak valid.'], 400);
        }

        $item->status = 'proses';
        $item->save();

        return response()->json(['success' => true, 'message' => 'Status pengajuan berhasil diubah menjadi proses.']);
    }
}
