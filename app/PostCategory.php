<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class PostCategory extends Model
{
    use HasTranslations;

    protected $fillable = [
    'slug', 'name', 'keyword', 'meta_desc'
];

    public $translatable = ['name', 'keyword','meta_desc'];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
