<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminSetting extends Model
{
    protected $fillable = [
        'no_rekening',
        'latitude',
        'longitude',
        'alamat_detail',
    ];
}
