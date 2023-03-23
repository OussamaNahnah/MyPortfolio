<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\Experience;
class JobResponsibility extends Model
{
    use HasFactory;


    protected $fillable = [
        'id',
        'responsibility',
        'user_id',
        'icon',
        'user_id',
    ];

    public function experiences(): BelongsTo
    {
        return $this->belongsTo(Experience::class);
    }
}