<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'path',
        'user_id',
    ];

    // photo belongs to many posts morph many
    public function posts()
    {
        return $this->morphedByMany(Post::class, 'photoable');
    }
}
