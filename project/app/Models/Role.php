<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    use HasFactory;

    protected $table = 'roles';

    protected $guarded = [
        'id',
        // 'created_at', 'updated_at'
    ];

    public function user(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'roles_users');
    }
}
