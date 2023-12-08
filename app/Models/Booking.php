<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    use HasFactory;

    protected $table = "bookings";


    protected $fillable = [
        'check-in',
        'check-out',
        'amount',
        'nights',
        'hotel_id'
    ];
    protected $hidden = [
        'hotel_id',
        'created_at',
        'updated_at'
    ];

    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class);
    }

    public function customers()
    {
        return $this->belongsToMany(Customer::class);
    }
}
