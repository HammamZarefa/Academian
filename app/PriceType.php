<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class PriceType extends Model
{
    use HasTranslations;

    protected $fillable = [
        'id',
        'name',
    ];

    public $translatable = ['name'];
}
