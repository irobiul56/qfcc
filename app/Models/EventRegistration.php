<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'full_name',
        'email',
        'phone',
        'guests',
        'notes',
        'status',
    ];

    protected $casts = [
        'guests' => 'integer',
    ];

    /* --- Relations --- */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    /* --- Scopes --- */
    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /* --- Helpers --- */
    public function confirm(): void
    {
        $this->update(['status' => 'confirmed']);
    }

    public function cancel(): void
    {
        $this->update(['status' => 'cancelled']);
    }
}