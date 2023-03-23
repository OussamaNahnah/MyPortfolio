<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\User;

class Education extends Model
{
    use HasFactory;


    protected $fillable = [
        'id',
        'nameschool',
        'specialization',
        'startdate',
        'enddate',        
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}