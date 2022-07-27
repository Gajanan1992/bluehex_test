<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'path',
        'user_id',
    ];

    // video morphed by many posts \
    public function posts()
    {
        return $this->morphedByMany(Post::class, 'videoable');
    }
}
