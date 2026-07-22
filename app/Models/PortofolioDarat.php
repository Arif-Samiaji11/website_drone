<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PortofolioDarat extends Model
{
    protected $fillable = [
        'judul',
        'deskripsi',
        'lokasi',
        'tanggal',
        'cover',        // foto thumbnail (upload)
        'youtube_url',  // link video YouTube
    ];
}
