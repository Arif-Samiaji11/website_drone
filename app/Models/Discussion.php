<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Discussion extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'service_type',
        'title',
        'status',
    ];

    public function getServiceLabelAttribute()
    {
        return match ($this->service_type) {
            'booking_drone' => 'Booking Jasa Drone',
            'booking_crews' => 'Photographer & Videographer',
            'servis_drone' => 'Servis Unit Drone',
            'order_drone' => 'Order Unit Drone',
            default => 'Diskusi Jasa Drone',
        };
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(DiscussionMessage::class);
    }
}
