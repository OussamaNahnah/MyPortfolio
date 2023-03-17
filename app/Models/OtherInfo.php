<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtherInfo extends Model
{
    use HasFactory;


    protected $fillable = [
        'id',
        'description',
        'user_id',
        'icon',
        'user_id',
    ];
}