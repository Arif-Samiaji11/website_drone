<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BookingDrone;
use App\Models\BookingCrew;
use App\Models\OrderDrone;
use App\Models\ServisDrone;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // 1. Get counts
        $counts = [
            'booking_drone' => [
                'total' => BookingDrone::count(),
                'new' => BookingDrone::where('status', 'baru')->count(),
            ],
            'booking_crew' => [
                'total' => BookingCrew::count(),
                'new' => BookingCrew::where('status', 'baru')->count(),
            ],
            'order_drone' => [
                'total' => OrderDrone::count(),
                'new' => OrderDrone::where('status', 'baru')->count(),
            ],
            'servis_drone' => [
                'total' => ServisDrone::count(),
                'new' => ServisDrone::where('status', 'baru')->count(),
            ],
        ];

        // 2. Fetch latest submissions of each type
        $recentBookingDrones = BookingDrone::latest()->take(5)->get()->map(function ($item) {
            $item->submission_type = 'booking_drone';
            $item->submission_label = 'Booking Drone';
            $item->badge_color = 'bg-blue-100 text-blue-800 border-blue-200';
            $item->manage_route = route('admin.booking-drone.index');
            return $item;
        });

        $recentBookingCrews = BookingCrew::latest()->take(5)->get()->map(function ($item) {
            $item->submission_type = 'booking_crew';
            $item->submission_label = 'Booking Crew';
            $item->badge_color = 'bg-purple-100 text-purple-800 border-purple-200';
            $item->manage_route = route('admin.booking-crews.index');
            return $item;
        });

        $recentOrderDrones = OrderDrone::latest()->take(5)->get()->map(function ($item) {
            $item->submission_type = 'order_drone';
            $item->submission_label = 'Order Drone';
            $item->badge_color = 'bg-emerald-100 text-emerald-800 border-emerald-200';
            $item->manage_route = route('admin.order-drone.index');
            return $item;
        });

        $recentServisDrones = ServisDrone::latest()->take(5)->get()->map(function ($item) {
            $item->submission_type = 'servis_drone';
            $item->submission_label = 'Servis Drone';
            $item->badge_color = 'bg-amber-100 text-amber-800 border-amber-200';
            $item->manage_route = route('admin.servis-drone.index');
            return $item;
        });

        // Combine and sort by created_at desc
        $recentSubmissions = collect()
            ->merge($recentBookingDrones)
            ->merge($recentBookingCrews)
            ->merge($recentOrderDrones)
            ->merge($recentServisDrones)
            ->sortByDesc('created_at')
            ->take(8);

        return view('admin.dashboard', compact('counts', 'recentSubmissions'));
    }
}
