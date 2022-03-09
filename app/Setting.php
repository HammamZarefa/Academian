<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use DateTimeZone;


class Setting extends Model
{

    protected $fillable = [
        'option_key',
        'option_value'
    ];

    public $timestamps = false;

    static function get_list_of_time_zone()
    {
        $timezone_identifiers = DateTimeZone::listIdentifiers(DateTimeZone::ALL);

        foreach ($timezone_identifiers as $r) {
            $data[$r] = $r;
        }
        return $data;
    }

    // public static function general_dropdown()
    // {
    //     $data['time_zone'] = self::get_list_of_time_zone();

    //     return $data;
    // }

    public static function currency_dropdown()
    {
        $data['decimal_symbol'] = array(
            '.' => '. (Dot)',
            ',' => ', (Comma)'
        );

        $data['thousand_separator'] = array(
            '.' => '. (Dot)',
            ',' => ', (Comma)'
        );

        $data['list_of_digit_grouping_methods'] = [
            FORMAT_CURRENCY_METHOD_ONE => "10,000,000,000",
            FORMAT_CURRENCY_METHOD_TWO => "10,00,00,00,000",
            FORMAT_CURRENCY_METHOD_THREE => "100,0000,0000"
        ];

        return $data;
    }

    public static function homepage_form_elements()
    {
        return [
            'hero_title_1' => 'input',
            'hero_button_text' => 'input',
            'section_1_title' => 'input',
            'section_1_content' => 'textarea',
            'section_2_title' => 'input',
            'section_2_sub_title' => 'input',
            'section_3_title' => 'input',
            'section_3_sub_title' => 'input',
            'how_it_works_step_1' => 'input',
            'how_it_works_step_2' => 'input',
            'how_it_works_step_3' => 'input',
            'how_it_works_step_4' => 'input',
            'how_it_works_step_1_content' => 'textarea',
            'how_it_works_step_2_content' => 'textarea',
            'how_it_works_step_3_content' => 'textarea',
            'how_it_works_step_4_content' => 'textarea',
            'section_4_title' => 'input',
            'section_4_para_1_title' => 'input',
            'section_4_para_1_content' => 'textarea',
            'section_4_para_2_title' => 'input',
            'section_4_para_2_content' => 'textarea',
            'section_4_para_3_title' => 'input',
            'section_4_para_3_content' => 'textarea',
            'section_4_para_4_title' => 'input',
            'section_4_para_4_content' => 'textarea',
            'order_page_link_text' => 'input',            
            'footer_text'=> 'input',
            'company_about' => 'textarea', 
        ];
    }

    static function socialNetworks()
    {
        return [
            'facebook'=> 'input',
            'twitter'=> 'input',
            'instagram'=> 'input',
            'linkedin'=> 'input',
        ];
    }

    static function isJSON($string)
    {
        return is_string($string) && is_array(json_decode($string, true)) ? true : false;
    }

    static function get_setting($key)
    {
        $records = self::where('option_key', $key)->get();

        if ($records->count() > 0) {
            $string = $records->first()->option_value;

            if (is_string($string) && is_array(json_decode($string, true))) {
                return json_decode($string);
            } else {
                return $string;
            }
        }

        return FALSE;
    }

    static function save_settings($data, $auto_load_disabled = NULL)
    {
        
        foreach ($data as $key => $value) {
            $obj = self::updateOrCreate([
                'option_key' => $key
            ]);
            $obj->option_value = trim($value);
            $obj->auto_load_disabled = $auto_load_disabled;
            $obj->save();
        }
    }

    static function seoInputFields($query = NULL)
    {
        $pages = [
            'home',
            'pricing',
            'how_it_works',
            'faq',
            'contact',
            'instant_quote',
            'money_back_guarantee',
            'privacy_policy',
            'revision_policy',
            'disclaimer',
            'terms_and_conditions'
        ];

        $meta_tags = [
            'title',
            'description',
            'keywords'
        ];

        $data = [];

        foreach ($pages as $page) {
            foreach ($meta_tags as $tag) {

                //example output: seo_title_home
                $field = 'seo_' . $tag . '_' . $page;

                switch ($query) {
                    case 'grouped':
                        $data['grouped'][$page][] = $field;
                        break;
                    case 'ungrouped':
                        $data['ungrouped'][] = $field;
                        break;
                    default:
                        $data['grouped'][$page][] = $field;
                        $data['ungrouped'][] = $field;
                        break;
                }
            }
        }

        switch ($query) {
            case 'grouped':
                $fields = $data['grouped'];
                break;
            case 'ungrouped':
                $fields = $data['ungrouped'];
                break;
            default:
                $fields = $data;
                break;
        }

        return $fields;
    }

    static function getSeoFieldsByPage($page)
    {
        $pages = self::seoInputFields('grouped');
        
        return optional($pages)[$page];
    }


}
