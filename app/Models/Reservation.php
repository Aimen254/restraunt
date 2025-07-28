<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
       protected $fillable = [
        'user_id',
        'table_id',
        'reservation_date',
        'reservation_time',
        'party_size',
        'status',
        'special_requests',
    ];

     public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the table for the reservation.
     */
    public function table()
    {
        return $this->belongsTo(Table::class); // Make sure you have a Table model
    }
}
