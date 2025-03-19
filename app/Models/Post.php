<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    protected $fillable = [
        'title',
        'content',
        'UserId'
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'UserId');
    }

    public function commints(): HasMany
    {
        return $this->hasMany(Commint::class, 'PostId');
    }
}
