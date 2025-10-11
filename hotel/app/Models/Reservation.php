<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    /**
     * The room that this reservation is for.
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * The guest who owns this reservation.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}