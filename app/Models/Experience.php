<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    use HasFactory;


    protected $fillable = [
        'id',
        'name',
        'titlejob',
        'location',
        'startdate',  
        'enddate',
        'user_id',
    ];
}