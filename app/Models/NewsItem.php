<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsItem extends Model
{
    // app/Models/NewsItem.php
// app/Models/NewsItem.php
protected $fillable = [
    'title',
    'slug',
    'excerpt',
    'url',
    'source',
    'published_at',
];




    protected $casts = [
        'published_at' => 'datetime',
    ];
}
