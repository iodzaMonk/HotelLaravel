<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;
    protected $fillable = ['hotel_name', 'hotel_address'];

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

}