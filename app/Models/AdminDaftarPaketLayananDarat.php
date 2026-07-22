<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdminDaftarPaketLayananDarat extends Model
{
    protected $table = 'admin_daftar_paket_layanan_darat';

    protected $fillable = [
        'layanan_id',
        'kode',
        'nama',
        'deskripsi',
        'is_active',
        'sort_order',
    ];

    public function layanan(): BelongsTo
    {
        return $this->belongsTo(AdminDaftarLayananDarat::class, 'layanan_id');
    }
}
