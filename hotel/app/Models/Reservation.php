<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    //

    public function reservation()
    {
        return $this->hasOne(Hotel::class);
    }

    public function users()
    {
        return $this->hasOne(User::class);
    }
}