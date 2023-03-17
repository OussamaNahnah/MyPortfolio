<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;


    protected $fillable = [
        'id',
        'name',
        'description',
        'link',
        'thumb_img',
        'org_img',        
        'user_id',
    ];
}