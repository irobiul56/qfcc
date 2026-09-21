<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    use HasFactory;

    protected $fillable = [
        'membership_type',
        'amount',
        'full_name',
        'dob',
        'gender',
        'marital_status',
        'occupation',
        'address',
        'city',
        'state',
        'zip',
        'phone',
        'email',
        'skills',
        'spouse_name',
        'spouse_dob',
        'spouse_occupation',
        'children',
        'emergency_name',
        'emergency_relationship',
        'emergency_phone',
        'emergency_email',
        'status',
    ];

    protected $casts = [
        'dob'         => 'date',
        'spouse_dob'  => 'date',
        'children'    => 'array',
        'amount'      => 'decimal:2',
    ];

    // Auto-set the fee based on the plan
    protected static function booted(): void
    {
        static::creating(function (Membership $membership) {
            $membership->amount = match ($membership->membership_type) {
                'General Member'  => 100.00,
                'Lifetime Member' => 300.00,
                default           => 0.00,
            };
        });
    }

    public function transactions()
{
    return $this->hasMany(Transaction::class);
}

public function latestTransaction()
{
    return $this->hasOne(Transaction::class)->latestOfMany();
}

/* Helper to check if paid */
public function isPaid(): bool
{
    return $this->transactions()->where('status', 'completed')->exists();
}
}