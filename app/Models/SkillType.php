<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\Skill;

class SkillType extends Model
{
    use HasFactory;


    protected $fillable = [
        'id',
        'name', 
        'user_id',
    ];
    public function skills(): HasMany
    {
        return $this->hasMany(Skill::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}