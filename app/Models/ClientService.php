<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientService extends Model
{
    protected $fillable = [
        'user_id', 'client_id', 'service_type_id', 'title',
        'start_date', 'expiry_date', 'notes', 'last_reminded_on',
    ];

    protected $casts = [
        'start_date'       => 'date',
        'expiry_date'      => 'date',
        'last_reminded_on' => 'date',
    ];

    public function user() { return $this->belongsTo(User::class); }
    public function client() { return $this->belongsTo(Client::class); }
    public function serviceType() { return $this->belongsTo(ServiceType::class); }

    // Kitne din baaki (negative = expire ho chuki)
    public function getDaysLeftAttribute(): int
    {
        return (int) today()->diffInDays($this->expiry_date, false);
    }

    public function scopeExpiringWithin($query, int $days)
    {
        return $query->whereDate('expiry_date', '>=', today())
                     ->whereDate('expiry_date', '<=', today()->addDays($days));
    }
}
