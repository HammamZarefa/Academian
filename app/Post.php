<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Post extends Model
{
    use SoftDeletes;
    use HasTranslations;

    protected $guarded = [];

    protected $fillable = ['category_id','author_id','title','slug','cover','body','body_type','keyword','meta_desc','views','status','feature'];

    public $translatable = ['title', 'body','keyword','meta_desc'];

    public function category()
    {
        return $this->belongsTo(PostCategory::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class,'author_id');
    }

    // public function admin()
    // {
    //     return $this->belongsTo(Admin::class,'author_id');
    // }

    public function tags()
    {
        return $this->belongsToMany(PostTag::class,'post_tag','post_id','tag_id');
    }

}
