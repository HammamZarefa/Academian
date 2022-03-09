<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class NumberGenerator extends Model
{

    public $timestamps = false;

    static function gen($generatable_type)
    {
        $obj = self::where('generatable_type', $generatable_type)->get()->first();

        if ($obj) {
            $obj->last_generated_value ++;
            $generated_number = sprintf('%06d', $obj->last_generated_value);
        } else {
            $obj = new NumberGenerator();
            $obj->generatable_type = $generatable_type;
            $generated_number = "000001";
        }

        $obj->last_generated_value = $generated_number;
        $obj->save();

        return self::get_prefix($generatable_type) . "-" . $generated_number;
    }

    private static function get_prefix($generatable_type)
    {
        $prefix_list = [
            'App\Bill' => 'BILL',
            'App\Order' => 'ORD',
            'App\Payment' => 'PMT',
            'App\Wallet' => 'WAL',          
        ];

        return (isset($prefix_list[$generatable_type])) ? $prefix_list[$generatable_type] : NULL;
    }
}
