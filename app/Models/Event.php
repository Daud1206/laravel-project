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
        // jangan masukkan status temporal karena computed
    ];

    // Relationship
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Return temporal status based on date:
     * - 'expired'      => event date < today
     * - 'ongoing'      => event date == today
     * - 'coming_soon'  => event date > today
     */
    public function getTemporalStatusAttribute()
    {
        // gunakan Carbon::today() agar timezone aplikasi konsisten
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

    // Helpers (optional, memudahkan di controller/view)
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
