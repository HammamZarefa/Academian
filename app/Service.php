<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\PriceType;
use App\AdditionalService;
use App\ServiceCategory;
use Spatie\Translatable\HasTranslations;

class Service extends Model
{
    use HasTranslations;

    protected $fillable = [
        'id',
        'name',
        'price_type_id',
        'price',
        'single_spacing_price',
        'double_spacing_price',
        'minimum_order_quantity',
        'inactive',
        'service_category_id'
    ];

    public $translatable = ['name'];

    /**
     * The additionalServices that belong to the Service.
     */
    public function additionalServices()
    {
        return $this->belongsToMany('App\AdditionalService', 'service_tag_additional_services');
    }

    public function price_type()
    {
        return $this->belongsTo('App\PriceType');
    }

    public function service_category()
    {
        return $this->belongsTo('App\ServiceCategory');
    }

    public static function dropdown()
    {
        $data['price_type_list'] = PriceType::pluck('name', 'id')->toArray();
        $data['additional_services_list'] = AdditionalService::pluck('name', 'id')->toArray();
        $data['service_category_list'] = ServiceCategory::pluck('name', 'id')->toArray();
        return $data;
    }
}
