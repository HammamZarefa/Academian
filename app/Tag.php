<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Tag extends Model
{

    use SoftDeletes;
    use HasTranslations;


    protected $dates = [
        'deleted_at'
    ];

    protected $fillable = [
        'name'
    ];

    public $translatable = ['name'];
}
