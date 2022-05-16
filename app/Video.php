<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Video extends Model
{
    use SoftDeletes;
    use HasTranslations;

    protected $guarded = [];

    protected $fillable = ['title','url','feature'];

    public $translatable = ['title'];

}
