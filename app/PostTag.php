<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostTag extends Model
{


    public function Posts()
    {
        return $this->belongsToMany(Post::class,'post_tag','tag_id','post-id');
    }
}
