<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class OfflinePaymentMethod extends Model
{
    use HasTranslations;
    protected $casts = [
        'settings' => 'object',
        'inactive' => 'boolean'
    ];

    protected $fillable = [
        'slug',
        'name',
        'description',
        'instruction',
        'settings',
        'success_message',
        'inactive'
    ];

    public $translatable = ['name', 'description','instruction','settings','success_message'];

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
