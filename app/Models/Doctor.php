<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Modules\Post\App\Models\Post;

class Doctor extends Authenticatable implements HasMedia
{
    use 
        HasApiTokens, 
        HasFactory, 
        Notifiable,
        HasRoles,
        InteractsWithMedia;
    protected $fillable = [
        'name',
        'email',
        'password',
        'birth',
        'provider',
        'provider_id'
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('doctor_profile_image');
    }
    protected function Birth(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->format('d-m-Y'),
            set: fn ($value) => Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d')
        );
    }
    public function posts() :HasMany
    {
        return $this->hasMany(Post::class);
    }
}
