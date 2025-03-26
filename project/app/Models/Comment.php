<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory;

    protected $table = 'comments';

    protected $visible = [
        'id',
        'text',
        'rating',
        'parent_id',
        'created_at',
        'author'
    ];

    protected $fillable = [
        'text',
        'rating',
        'film_id',
        'user_id',
        'parent_id',
    ];

    protected $appends = [
        'author'
    ];

    protected $casts = [
        'rating' => 'float',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function film()
    {
        return $this->belongsTo(Film::class);
    }

    public function getAuthorAttribute()
    {
        return $this->user?->name ?? "Гость";
    }
}
