<?php
include_once 'form_helper.php';
include_once 'currency_helper.php';

// For cached settings only
function settings($key)
{
    $record =  NULL;

    $setting =  Cache::rememberForever('settings', function () {
        return \App\Setting::whereNull('auto_load_disabled')->get();
    });

    if ($setting && $setting->count() > 0) {
        $record = $setting->where('option_key', $key);
    }

    if (!empty($record) && !empty(optional($record->first())->option_value)) {
        return $record->first()->option_value;
    } else {
        return \App\Setting::get_setting($key);
    }
}

function homepage($key)
{
    $record =  NULL;

    $setting = Cache::rememberForever('homepage', function () {
        $fields = array_keys(\App\Setting::homepage_form_elements());
        return \App\Setting::whereIn('option_key', $fields)->get();
    });

    if ($setting && $setting->count() > 0) {
        $record = $setting->where('option_key', $key);
    }

    if (!empty($record) && !empty(optional($record->first())->option_value)) {
        return Purifier::clean($record->first()->option_value);
    } else {
        return Purifier::clean(\App\Setting::get_setting($key));
    }
}

function get_company_logo()
{
    if ($company_logo = settings('company_logo')) {

        return asset(Storage::url($company_logo));
    }
}

function get_favicon()
{
    if (Config::get('constants.favicon')) {
        return asset(Storage::url(Config::get('constants.favicon')));
    }
}

function pr($data)
{
    echo "<pre>";
    print_r($data);
    die();
}

function debug($e)
{
    echo $e->getMessage() . " <br> " . $e->getLine() . "<br>" . $e->getFile();
    die();
}

function get_urgency_date($type, $value, $format = 'D, M j, Y')
{
    $now = \Carbon\Carbon::now();

    $now = ($type == 'hours') ? $now->addHours($value) : $now->addDays($value);

    return $now->format($format);
}

function is_active_menu($route_name)
{
    return request()->routeIs($route_name) ? 'active' : '';
}

function get_company_name()
{
    return Purifier::clean(settings('company_name'));
}

function get_software_version()
{
    return '1.7';
}

function bottom_toolbar($text = NULL)
{
    $text = ($text) ? $text : 'Submit';

    ob_start();
?>
    <div class="row bottom-toolbar">
        <div class="col-md-12">
            <div style="text-align: right;">
                <input type="submit" class="btn btn-primary btn-lg" value="<?php echo $text; ?>" />

            </div>
        </div>
    </div>
<?php

    flush();
    ob_flush();
    ob_end_flush();
}

function showErrorClass($errors, $key)
{
    if ($errors->has($key)) {
        echo 'is-invalid';
    }
}

function showError($errors, $key)
{
    if ($errors->has($key)) {
        echo $errors->first($key);
    }
}

function hideElementIfApplicable($name, $model)
{
    return old_set($name, NULL, $model) ? null : 'display:none;';
}

function is_active_nav($item_name, $group_name)
{
    return ($group_name == $item_name) ? 'active' : '';
}

function format_money($amount)
{
    return format_currency($amount, TRUE);
}

function get_default_route_by_user($user)
{
    if ($user->hasRole('admin')) {
        return 'dashboard';
    } elseif ($user->hasRole('staff')) {
        return 'tasks_list';
    } else {
        return 'order_page';
    }
}

function sql2date($date)
{
    return date("d-M-Y", strtotime($date));
}

function load_route($route_name)
{
    require base_path() . '/routes/splitted/' . $route_name . '.php';
}

function company_notification_email()
{
    return settings('company_notification_email');
}


function growl_notification()
{
    // https://www.cssscript.com/demo/beautiful-growl-notification/
    if (session()->has('success')) {
        $data = [
            'position' => 'top-right',
            'type' => 'success',
            'title' => 'Success',
            'description' => session()->get('success'),
            'closeTimeout' => 4000,
            'zIndex'=> '2000'
        ];
    } elseif (session()->has('fail')) {
        $data = [
            'position' => 'top-right',
            'type' => 'error',
            'title' => 'Failed',
            'description' => session()->get('fail'),
            'closeTimeout' => 4000,
            'zIndex'=> '2000'
        ];
    } elseif (session()->has('info')) {
        $data = [
            'position' => 'top-right',
            'type' => 'info',
            'title' => 'Sorry!',
            'description' => session()->get('info'),
            'closeTimeout' => 4000,
            'zIndex'=> '2000'
        ];
    }

    if (isset($data) && count($data) > 0) {
        return 'GrowlNotification.notify(' . json_encode($data) . ');';
    }

    return NULL;
}

function star_rating($number)
{
    $stars = 5;

    for ($i = 1; $i <= $stars; $i++) {
        $fill = ($i <= $number) ? 'star-filled' : 'star-unfilled';
        echo '<i class="fas fa-1x fa-star ' . $fill . '"></i>';
    }
}

function user_photo($photo)
{
    return ($photo) ? asset(Storage::url($photo)) : asset('images/user-placeholder.jpg');
}


function logActivity($performedOn = NULL, $log, $user = NULL, $properties = NULL)
{
    $user = (empty($user)) ? auth()->user() : $user;
    $activity = activity()->causedBy($user);

    if($performedOn)
    {
        $activity->performedOn($performedOn);
    }    
   
    if ($properties) {
        $activity->withProperties($properties);
    }
    return $activity->log($log);
}


function anchor($text, $url, $class = null)
{
    return '<a href="' . $url . '" class="' . $class . '">' . $text . '</a>';
}



function isRevisionAllowed($order)
{
    $number_of_revision_allowed = settings('number_of_revision_allowed');

    if ($number_of_revision_allowed == -1) {
        return true;
    }

    $revision_already_used = $order->revisionUsed();

    if ($revision_already_used < $number_of_revision_allowed) {
        return true;
    }

    return false;
}

function pushNotification($user_id)
{
    $notification = \App\PushNotification::updateOrCreate([
        'user_id' => $user_id
    ]);
    $notification->number++;
    $notification->save();
}

function anchor_link($main_text, $link, $newTab = NULL)
{
    $newTab = (isset($newTab) && $newTab == TRUE) ? 'target="_blank"' : '';
    return ' <a ' . $newTab . ' class="" href="' . $link . '">' . $main_text . '</a>';
}

function currencyConfig()
{
    return json_encode([
        'currency' => [
            'symbol' => settings('currency_symbol'),
            'format' => '%s%v',
            'decimal' => settings('decimal_symbol'),  // decimal point separator
            'thousand' => settings('thousand_separator'),  // thousands separator
            'precision' => 2   // decimal places
        ],
        'number' => [
            'precision' => 2,
            'thousand' => settings('thousand_separator'),
            'decimal' => settings('decimal_symbol'),
        ]
    ]);
}
// Order Status
define('ORDER_STATUS_NEW', 1);
define('ORDER_STATUS_IN_PROGRESS', 2);
define('ORDER_STATUS_SUBMITTED_FOR_APPROVAL', 3);
define('ORDER_STATUS_REQUESTED_FOR_REVISION', 4);
define('ORDER_STATUS_COMPLETE', 5);
define('ORDER_STATUS_ON_HOLD', 6);
define('ORDER_STATUS_CANCELED', 6);
define('ORDER_STATUS_REFUNDED', 8);
define('ORDER_STATUS_PENDING_PAYMENT', 9);
define('ORDER_STATUS_PAYMENT_NEEDS_APPROVAL', 10);
define('ORDER_STATUS_PAYMENT_DISAPPROVED', 11);



// define('ORDER_STATUS_SUBMITTED_FOR_QA', 9);

function convertToLocalTime($value, $format='d-M-Y H:i:s')
{
    $timezone = (auth()->user()->timezone) ? auth()->user()->timezone : 'utc';

    if ($value instanceof \Illuminate\Support\Carbon) {
        return $value->setTimezone($timezone)->format($format);
    }
}

function paymentIsPending($orderStatusId)
{
    if (in_array($orderStatusId, [
        ORDER_STATUS_PENDING_PAYMENT,
        ORDER_STATUS_PAYMENT_NEEDS_APPROVAL,
        ORDER_STATUS_PAYMENT_DISAPPROVED
    ])) {
        return true;
    }
}