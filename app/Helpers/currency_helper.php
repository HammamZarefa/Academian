<?php

define('FORMAT_CURRENCY_METHOD_ONE', 1);
define('FORMAT_CURRENCY_METHOD_TWO', 2);
define('FORMAT_CURRENCY_METHOD_THREE', 3);

function format_currency($input, $with_currency = FALSE, $cur_symbol = NULL)
{
    $method                     = settings('digit_grouping_method');
    $round_precision            = 2;
    $decimal_symbol             = settings('decimal_symbol');
    $digit_grouping_symbol      = settings('thousand_separator');
    $currency_symbol            = settings('currency_symbol');
    // $method                 = 1;
    // $round_precision            = 2 ;
    // $decimal_symbol             =  '.' ;
    // $digit_grouping_symbol      =  ',' ;
    // $currency_symbol            = '$';


    if ($method == FORMAT_CURRENCY_METHOD_ONE) {
        $num_of_digits_to_separate_from_last_part   = 3;
        $num_of_digits_for_grouping                 = 3;
    } elseif ($method == FORMAT_CURRENCY_METHOD_TWO) {
        $num_of_digits_to_separate_from_last_part   = 3;
        $num_of_digits_for_grouping                 = 2;
    } elseif ($method == FORMAT_CURRENCY_METHOD_THREE) {
        $num_of_digits_to_separate_from_last_part   = 4;
        $num_of_digits_for_grouping                 = 4;
    }



    $val = format_currency_helper($input, $round_precision, $decimal_symbol, $digit_grouping_symbol, $num_of_digits_to_separate_from_last_part, $num_of_digits_for_grouping);

    $symbol = ($cur_symbol) ? $cur_symbol : $currency_symbol;

    if ($val) {
        if ($with_currency) {
         
            if ($val < 0) {            
                return '- ' . $symbol . str_replace('-', '', $val);
            } else {
               
                return $symbol . $val;
            }
        } else {
            return $val;
        }
    } elseif ($val == 0) {
        return ($with_currency) ? $symbol . 0 : 0;
    } else {
        return "";
    }
}



/*
 * Currency Formatting Types
    Style A: 10,000,000,000 // Most currencies
    Style B: 10,00,00,00,000 // South East Asian
    Style C: 100,0000,0000 // Japan, China
 */

// Covers Most currencies in the world
function format_currency_helper($input, $round_precision, $decimal_symbol, $digit_grouping_symbol, $num_of_digits_to_separate_from_last_part, $num_of_digits_for_grouping)
{
    $is_negative = false;
    if ($input < 0) {
        $is_negative = true;
        $input = abs($input);
    }
    //CUSTOM FUNCTION TO GENERATE ##,##,###.##
    $dec = "";
    $pos = strpos($input, $decimal_symbol);

    if ($pos != false) {
        //decimals
        $dec = substr(number_format(substr($input, $pos), $round_precision), 1);
        $input = substr($input, 0, $pos);
    }

    $num = substr($input, -$num_of_digits_to_separate_from_last_part); //get the last 3 digits
    $input = substr($input, 0, -$num_of_digits_to_separate_from_last_part); //omit the last 3 digits already stored in $num

    while (strlen($input) > 0) //loop the process - further get digits 2 by 2
    {
        $num = substr($input, -$num_of_digits_for_grouping) . $digit_grouping_symbol . $num;
        $input = substr($input, 0, -$num_of_digits_for_grouping);
    }
    $a = $num . $dec;

    return ($is_negative == true) ? "-" . $a : $a;
}
