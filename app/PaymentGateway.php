<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class PaymentGateway extends Model
{
    use HasTranslations;
    protected $casts = [
        'keys' => 'object',
        'inactive'=> 'boolean'
    ];

    protected $fillable = [
        'unique_name',
        'name',
        'mode',
        'keys',
        'inactive'
    ];

    public $translatable = ['name'];

    static function getByUniqueName($unique_name)
    {
        $records = self::where('unique_name', $unique_name)
        ->whereNull('inactive')->get();

        return ($records->count() > 0) ? $records->first() : NULL;

    }


}
