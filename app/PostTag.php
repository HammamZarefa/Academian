<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostTag extends Model
{


    public function Posts()
    {
        return $this->belongsToMany(Post::class);
    }
}
