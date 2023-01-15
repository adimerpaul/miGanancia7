<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shop extends Model
{
    use HasFactory,softDeletes;
    protected $fillable = [
        'avatar',
        'type',
        'name',
        'address',
        'city',
        'phone',
        'email',
        'document',
        'user_id',
        'status'
    ];
}
