<?php
namespace App\Services;

use Artesaos\SEOTools\Facades\SEOMeta;
use App\Setting;
use Artesaos\SEOTools\Facades\SEOTools;

class SeoService
{

    public function load($page)
    {
        $fields = Setting::getSeoFieldsByPage($page);

        if ($fields) {

            $meta = Setting::whereIn('option_key', $fields)->pluck('option_value', 'option_key');

            if ($meta->count() > 0) {

                $title = $meta['seo_title_'.$page] . ' - ' . get_company_name();

                SEOTools::setTitle($title, false);
                SEOMeta::setDescription($meta['seo_description_' . $page], false);
                SEOTools::opengraph()->addProperty('type', 'product');
                SEOTools::opengraph()->setUrl(url()->current());
                SEOTools::setDescription($meta['seo_description_' . $page], false);
                $keyword = $meta['seo_keywords_' . $page];

                if ($keyword) {
                    SEOMeta::addKeyword(explode(',', $keyword));
                }

                request()->session()->flash('seo_was_set', TRUE);
            }
        }
    }
}