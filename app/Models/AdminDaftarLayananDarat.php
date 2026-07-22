<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AdminDaftarLayananDarat extends Model
{
    protected $table = 'admin_daftar_layanan_darat';

    protected $fillable = [
        'slug',
        'nama',
        'is_active',
        'sort_order',
    ];

    public function paket()
{
    return $this->hasMany(\App\Models\AdminDaftarPaketLayananDarat::class, 'layanan_id')
        ->orderBy('sort_order')
        ->orderBy('id');
}

}
