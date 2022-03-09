<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdditionalService extends Model
{
    protected $fillable = [
        'type', 'name', 'description', 'rate', 'inactive'
    ];
}
