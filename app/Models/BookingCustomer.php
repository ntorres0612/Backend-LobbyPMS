<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingCustomer extends Model
{
    use HasFactory;

    protected $table = "booking_customer";


    protected $fillable = [
        'booking_id',
        'customer_id',
    ];
    protected $hidden = [
        'booking_id',
        'customer_id',
    ];
}
