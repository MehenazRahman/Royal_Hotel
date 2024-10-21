<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bookings extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'name',
        'email',
        'phone',
        'check_in',
        'check_out',
        'rooms_no',
        'children',
    ];

    public function room(){
        return $this->hasOne('App\Models\Room','id', 'room_id');
    }
}
