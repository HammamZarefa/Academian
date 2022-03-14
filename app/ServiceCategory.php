<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class ServiceCategory extends Model
{
    use HasTranslations;

    protected $fillable = [
        'id',
        'name',
        'desc',
        'worklevel'

    ];

    public $translatable = ['name', 'desc'];
    public function services()
    {
        return $this->hasMany('App\Service');
    }
}
