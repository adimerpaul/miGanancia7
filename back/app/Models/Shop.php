<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;
    protected $fillable = [
        'avatar',
        'type',
        'name',
        'address',
        'city',
        'phone',
        'email',
        'document'
    ];
}
