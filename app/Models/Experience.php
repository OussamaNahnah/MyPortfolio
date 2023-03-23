<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\User;
use App\Models\JobResponsibility;

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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function job_responsibilities() : HasMany
    {
        return $this->hasMany(JobResponsibility::class);
    }
}