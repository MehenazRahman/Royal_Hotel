<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodGallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'food_title',
        'food_description',
    ];
}
