<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingCrew extends Model
{
    protected $fillable = [
        'layanan',
        'paket',
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
    ];
}
