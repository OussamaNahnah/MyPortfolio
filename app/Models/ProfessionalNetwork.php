<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfessionalNetwork extends Model
{
    use HasFactory;


    protected $fillable = [
        'id',
        'name',
        'link',
        'icon',
        'user_id',
    ];
}