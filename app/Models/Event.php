<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Event extends Model
{
    protected $fillable = [
        'title',
        'category_id',
        'location',
        'date',
        'contact_phone',
        'description',
        'user_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'event_user')
                    ->withTimestamps();
    }

    public function getTemporalStatusAttribute()
    {
        $today = Carbon::today();
        $eventDate = Carbon::parse($this->date)->startOfDay();

        if ($eventDate->lt($today)) {
            return 'expired';
        }

        if ($eventDate->eq($today)) {
            return 'ongoing';
        }

        return 'coming_soon';
    }

    public function isExpired()
    {
        return $this->temporal_status === 'expired';
    }

    public function isOngoing()
    {
        return $this->temporal_status === 'ongoing';
    }

    public function isComingSoon()
    {
        return $this->temporal_status === 'coming_soon';
    }
}
