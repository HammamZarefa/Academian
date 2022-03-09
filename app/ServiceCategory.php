<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceCategory extends Model
{
    protected $fillable = [
        'id',
        'name',
        'desc',
        'worklevel'

    ];
    public function services()
    {
        return $this->hasMany('App\Service');
    }
}
