<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingDrone extends Model
{
    protected $fillable = [
        'nama',
        'email',
        'hp',
        'lokasi',
        'tanggal',
        'catatan',
        'portofolio_id',
        'status',
        'dp_booking_tanggal',
        'bukti_pembayaran_dp',
        'tipe_jadwal',
        'tanggal_selesai_acara',
        'estimasi_selesai_acara',
        'waktu_mulai_acara'
    ];

    //
}
