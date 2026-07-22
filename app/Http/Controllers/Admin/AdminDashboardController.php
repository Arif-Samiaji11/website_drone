<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BookingDrone;
use App\Models\BookingCrew;
use App\Models\OrderDrone;
use App\Models\ServisDrone;
use App\Models\User;
use App\Models\Discussion;

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

        // 2. Fetch latest submissions of each type and map discussions
        $recentBookingDrones = BookingDrone::latest()->take(5)->get()->map(function ($item) {
            $item->submission_type = 'booking_drone';
            $item->submission_label = 'Booking Drone';
            $item->badge_color = 'bg-blue-100 text-blue-800 border-blue-200';
            $item->manage_route = route('admin.booking-drone.index');
            
            // Link discussion
            $user = User::where('email', $item->email)->first();
            $item->discussion_id = null;
            if ($user) {
                $disc = Discussion::firstOrCreate(
                    ['user_id' => $user->id, 'service_type' => 'booking_drone'],
                    ['title' => 'Booking Jasa Drone - ' . $user->name]
                );
                $item->discussion_id = $disc->id;
            }
            return $item;
        });

        $recentBookingCrews = BookingCrew::latest()->take(5)->get()->map(function ($item) {
            $item->submission_type = 'booking_crew';
            $item->submission_label = 'Booking Crew';
            $item->badge_color = 'bg-purple-100 text-purple-800 border-purple-200';
            $item->manage_route = route('admin.booking-crews.index');
            
            // Link discussion
            $user = User::where('email', $item->email)->first();
            $item->discussion_id = null;
            if ($user) {
                // service_type for booking crew is booking_crews
                $disc = Discussion::firstOrCreate(
                    ['user_id' => $user->id, 'service_type' => 'booking_crews'],
                    ['title' => 'Photographer & Videographer - ' . $user->name]
                );
                $item->discussion_id = $disc->id;
            }
            return $item;
        });

        $recentOrderDrones = OrderDrone::latest()->take(5)->get()->map(function ($item) {
            $item->submission_type = 'order_drone';
            $item->submission_label = 'Order Drone';
            $item->badge_color = 'bg-emerald-100 text-emerald-800 border-emerald-200';
            $item->manage_route = route('admin.order-drone.index');
            
            // Link discussion
            $user = User::where('email', $item->email)->first();
            $item->discussion_id = null;
            if ($user) {
                $disc = Discussion::firstOrCreate(
                    ['user_id' => $user->id, 'service_type' => 'order_drone'],
                    ['title' => 'Order Unit Drone - ' . $user->name]
                );
                $item->discussion_id = $disc->id;
            }
            return $item;
        });

        $recentServisDrones = ServisDrone::latest()->take(5)->get()->map(function ($item) {
            $item->submission_type = 'servis_drone';
            $item->submission_label = 'Servis Drone';
            $item->badge_color = 'bg-amber-100 text-amber-800 border-amber-200';
            $item->manage_route = route('admin.servis-drone.index');
            
            // Link discussion
            $user = User::where('email', $item->email)->first();
            $item->discussion_id = null;
            if ($user) {
                $disc = Discussion::firstOrCreate(
                    ['user_id' => $user->id, 'service_type' => 'servis_drone'],
                    ['title' => 'Servis Unit Drone - ' . $user->name]
                );
                $item->discussion_id = $disc->id;
            }
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

    public function fetchLatest()
    {
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

        $recentBookingDrones = BookingDrone::latest()->take(5)->get()->map(function ($item) {
            $item->submission_type = 'booking_drone';
            $item->submission_label = 'Booking Drone';
            $item->badge_color = 'bg-blue-100 text-blue-800 border-blue-200';
            $item->manage_route = route('admin.booking-drone.index');
            
            $user = User::where('email', $item->email)->first();
            $item->discussion_id = null;
            if ($user) {
                $disc = Discussion::firstOrCreate(
                    ['user_id' => $user->id, 'service_type' => 'booking_drone'],
                    ['title' => 'Booking Jasa Drone - ' . $user->name]
                );
                $item->discussion_id = $disc->id;
            }
            return $item;
        });

        $recentBookingCrews = BookingCrew::latest()->take(5)->get()->map(function ($item) {
            $item->submission_type = 'booking_crew';
            $item->submission_label = 'Booking Crew';
            $item->badge_color = 'bg-purple-100 text-purple-800 border-purple-200';
            $item->manage_route = route('admin.booking-crews.index');
            
            $user = User::where('email', $item->email)->first();
            $item->discussion_id = null;
            if ($user) {
                $disc = Discussion::firstOrCreate(
                    ['user_id' => $user->id, 'service_type' => 'booking_crews'],
                    ['title' => 'Photographer & Videographer - ' . $user->name]
                );
                $item->discussion_id = $disc->id;
            }
            return $item;
        });

        $recentOrderDrones = OrderDrone::latest()->take(5)->get()->map(function ($item) {
            $item->submission_type = 'order_drone';
            $item->submission_label = 'Order Drone';
            $item->badge_color = 'bg-emerald-100 text-emerald-800 border-emerald-200';
            $item->manage_route = route('admin.order-drone.index');
            
            $user = User::where('email', $item->email)->first();
            $item->discussion_id = null;
            if ($user) {
                $disc = Discussion::firstOrCreate(
                    ['user_id' => $user->id, 'service_type' => 'order_drone'],
                    ['title' => 'Order Unit Drone - ' . $user->name]
                );
                $item->discussion_id = $disc->id;
            }
            return $item;
        });

        $recentServisDrones = ServisDrone::latest()->take(5)->get()->map(function ($item) {
            $item->submission_type = 'servis_drone';
            $item->submission_label = 'Servis Drone';
            $item->badge_color = 'bg-amber-100 text-amber-800 border-amber-200';
            $item->manage_route = route('admin.servis-drone.index');
            
            $user = User::where('email', $item->email)->first();
            $item->discussion_id = null;
            if ($user) {
                $disc = Discussion::firstOrCreate(
                    ['user_id' => $user->id, 'service_type' => 'servis_drone'],
                    ['title' => 'Servis Unit Drone - ' . $user->name]
                );
                $item->discussion_id = $disc->id;
            }
            return $item;
        });

        $recentSubmissions = collect()
            ->merge($recentBookingDrones)
            ->merge($recentBookingCrews)
            ->merge($recentOrderDrones)
            ->merge($recentServisDrones)
            ->sortByDesc('created_at')
            ->take(8);

        $mappedSubmissions = $recentSubmissions->map(function ($item) {
            $item->created_at_formatted = $item->created_at->format('d M Y H:i');
            $item->created_at_human = $item->created_at->diffForHumans();
            $item->bukti_pembayaran_dp_url = $item->bukti_pembayaran_dp ? asset('storage/' . $item->bukti_pembayaran_dp) : null;
            $item->dp_formatted = $item->dp_booking_tanggal ? 'Rp ' . number_format($item->dp_booking_tanggal, 0, ',', '.') : '-';
            
            if ($item->submission_type === 'booking_drone' && $item->tanggal_selesai_acara) {
                $item->tanggal_selesai_acara_formatted = \Carbon\Carbon::parse($item->tanggal_selesai_acara)->format('d M Y');
            }
            return $item;
        })->values();

        return response()->json([
            'success' => true,
            'counts' => $counts,
            'recentSubmissions' => $mappedSubmissions
        ]);
    }
}
