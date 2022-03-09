<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Urgency extends Model
{

    protected $fillable = [
        'id',
        'type',
        'value',
        'percentage_to_add',
        'inactive'
    ];

    static function dropdown()
    {
        $data['types'] = [
            'hours' => 'hours',
            'days' => 'days'
        ];

        return $data;
    }
}
