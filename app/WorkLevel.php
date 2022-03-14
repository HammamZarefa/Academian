<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class WorkLevel extends Model
{
    use HasTranslations;

    protected $fillable = [
        'id',
        'name',
        'percentage_to_add',
        'inactive'
    ];

    public $translatable = ['name'];

    protected $casts = [
        'inactive' => 'boolean'
    ];
}
