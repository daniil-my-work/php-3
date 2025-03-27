<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Film extends Model
{
    use HasFactory;

    public const STATUS_PENDING = 'pending';
    public const STATUS_ON_MODERATION = 'moderate';
    public const STATUS_READY = 'ready';

    protected $table = "films";

    protected $with = ['genres'];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    protected $fillable = [
        'name',
        'poster_image',
        'preview_image',
        'background_image',
        'background_color',
        'video_link',
        'preview_video_link',
        'description',
        'director',
        'starring',
        'run_time',
        'released',
        'imdb_id',
        'status',
    ];

    protected $casts = [
        "starring" => "array",
        "run_time" => "integer",
        "released" => "integer",
        "promo" => "boolean",
    ];

    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function scores(): HasMany
    {
        return $this->hasMany(Comment::class)->whereNotNull('rating');
    }

    public function getRatingAttribute()
    {
        return round($this->scores()->avg('rating'), 1);
    }
}
