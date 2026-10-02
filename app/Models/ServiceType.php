<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceType extends Model
{
    protected $fillable = ['user_id', 'name'];

    public function services() { return $this->hasMany(ClientService::class); }

    // Naye user ke liye default service types
    public static function ensureDefaults(int $userId): void
    {
        if (static::where('user_id', $userId)->exists()) {
            return;
        }
        foreach (['Website', 'Hosting', 'Domain', 'SEO', 'AMC'] as $name) {
            static::create(['user_id' => $userId, 'name' => $name]);
        }
    }
}
