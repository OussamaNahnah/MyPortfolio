<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
//////////// 
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
///////////////////

use App\Models\User;
use App\Models\Skill;

class Project extends Model implements  HasMedia
{
    use HasFactory,InteractsWithMedia;

    protected $fillable = [
        'id',
        'name',
        'description',
        'link',       
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function skills(): BelongsToMany
    {
        return $this->belongsToMany(Skill::class)->withTimestamps();
    }
    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection("images")
            ->registerMediaConversions(function (Media $media) {
                $this
                    ->addMediaConversion('thumb')
                    ->width(300)
                    ->height(300);
                });
    } 
}