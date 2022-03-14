<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class AdditionalService extends Model
{
    use HasTranslations;
    protected $fillable = [
        'type', 'name', 'description', 'rate', 'inactive'
    ];

    public $translatable = ['name', 'description'];
}
