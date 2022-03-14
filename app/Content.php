<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Content extends Model
{
    use HasTranslations;

    protected $fillable = [
        'type',
        'slug',
        'title',
        'description'
    ];

    public $translatable = ['title', 'description'];
}
