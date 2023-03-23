<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
////////////
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
///////////////////
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
////////////
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use App\Models\ProfessionalNetwork;
use App\Models\Education;
use App\Models\PhoneNumber;
use App\Models\Experience;
use App\Models\Project;
use App\Models\OtherInfo;

class User extends Authenticatable implements JWTSubject , HasMedia
{
    use HasApiTokens, HasFactory, Notifiable,InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

   


    protected $fillable = [
        'id',
        'username',
        'fullname',
        'birthday',
        'email',
        'password',
        'location',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

  // Rest omitted for brevity

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection()
            ->singleFile();
    }
    public function registerMediaConversions(Media $media = null): void
    {
        $this
            ->addMediaConversion('thumb')
            ->fit(Manipulations::FIT_CROP, 300, 300)
            ->nonQueued();
    }

     public function professional_Networks(): HasMany
    {
        return $this->hasMany(ProfessionalNetwork::class);
    }
    public function educations(): HasMany
    {
        return $this->hasMany(Education::class);
    } 
    
    public function phone_numbers(): HasMany
    {
        return $this->hasMany(PhoneNumber::class);
    } 
    
    public function experiences() : HasMany
    {
        return $this->hasMany(Experience::class);
    } 
    
    public function projects() : HasMany
    {
        return $this->hasMany(Project::class);
    }

    public function other_infos(): HasOne
    {
        return $this->hasOne(OtherInfo::class);
    }
}