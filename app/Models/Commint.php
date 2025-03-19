<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Commint extends Model
{
    protected $fillable=
    [
        'content',
        'UserId',
        'PostId'
    ];
    
    public $timestamps = false;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'UserId');
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class, 'PostId');
    }
    
}
