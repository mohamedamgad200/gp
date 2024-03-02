<?php

namespace Modules\Post\App\Models;

use App\Models\Doctor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Post\Database\factories\PostFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Post extends Model implements HasMedia
{
    use HasFactory,InteractsWithMedia;
    protected $fillable = [
        'body',
        'doctor_id'
    ];
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('post_image');
    }
    public function doctor() :BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }
}
