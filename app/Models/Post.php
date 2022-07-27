<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'body',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    //post has many categoris

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'post_categories', 'post_id', 'category_id');
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
