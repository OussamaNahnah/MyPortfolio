<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

use App\Models\SkillType;
use App\Models\Project;

class Skill extends Model
{
    use HasFactory;


    protected $fillable = [
        'id',
        'name',
        'skill_type_id', 
    ];

    public function skill_type(): BelongsTo
    {
        return $this->belongsTo(SkillType::class);
    }

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class)->withTimestamps();
    }
}
 