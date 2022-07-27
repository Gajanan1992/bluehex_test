<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'comment',
        'user_id',
        'post_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    // post has many photos
    public function photos()
    {
        return $this->morphToMany(Photo::class, 'photoable');
    }
    // post has many videos
    public function videos()
    {
        return $this->morphToMany(Video::class, 'videoable');
    }
}
