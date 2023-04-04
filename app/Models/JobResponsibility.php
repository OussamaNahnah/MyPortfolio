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
        'experience_id',

    ];

    public function experience(): BelongsTo
    {
        return $this->belongsTo(Experience::class);
    }
}