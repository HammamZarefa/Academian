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
    $lang=app()->getLocale();
    $record =  NULL;

    $setting = Cache::rememberForever('homepage', function () {
        $fields = array_keys(\App\Setting::homepage_form_elements());
        return \App\Setting::whereIn('option_key', $fields)->get();
    });

    if ($setting && $setting->count() > 0) {
        $record = $setting->where('option_key', $key);
    }
    if (!empty($record) && !empty(optional($record->first())->option_value)) {
        return Purifier::clean(json_decode($record->first()->option_value)->$lang);
    } else {
        return Purifier::clean(\App\Setting::get_setting($key));
    }
}

function pricing_table($key)
{
    $record =  NULL;
//    json_decode(settings('pricing_table1'))->keys->service1
    $setting = Cache::rememberForever('pricing_table', function () {
        $fields = array_keys(\App\Setting::pricing_table());
        return \App\Setting::whereIn('option_key', $fields)->get();
    });
    $record = $setting->where('option_key', $key);
    return json_decode($record->first()->option_value);
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
    //moveable
    function curlContent($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    function languages()
    {
        $languages=Config::get('app.available_locales');
        return $languages;
    }
    function settingMenuState()
    {
        $state=true;
        return $state;
    }
}

function imagePath()
{
    $data['gateway'] = [
        'path' => 'assets/images/gateway',
        'size' => '800x800',
    ];
    $data['verify'] = [
        'withdraw' => [
            'path' => 'assets/images/verify/withdraw'
        ],
        'deposit' => [
            'path' => 'assets/images/verify/deposit'
        ]
    ];
    $data['image'] = [
        'default' => 'assets/images/default.png',
    ];
    $data['withdraw'] = [
        'method' => [
            'path' => 'assets/images/withdraw/method',
            'size' => '800x800',
        ]
    ];
    $data['ticket'] = [
        'path' => 'assets/images/support',
    ];
    $data['language'] = [
        'path' => 'assets/images/lang',
        'size' => '64x64'
    ];
    $data['logoIcon'] = [
        'path' => 'assets/images/logoIcon',
    ];
    $data['favicon'] = [
        'size' => '128x128',
    ];
    $data['extensions'] = [
        'path' => 'assets/images/extensions',
    ];
    $data['seo'] = [
        'path' => 'assets/images/seo',
        'size' => '600x315'
    ];
    $data['profile'] = [
        'user' => [
            'path' => 'assets/images/user/profile',
            'size' => '350x300'
        ],
        'admin' => [
            'path' => 'assets/admin/images/profile',
            'size' => '400x400'
        ]
    ];
    $data['category'] = [
        'path' => 'assets/images/category',
        'size' => '350x300'
    ];
    $data['service'] = [
        'path' => 'assets/images/service',
        'size' => '350x300'
    ];
    $data['banner'] = [
        'path' => 'assets/images/banner',
        'size' => '1530x640'
    ];
    return $data;
}


//moveable
function uploadImage($file, $location, $size = null, $old = null, $thumb = null)
{
    $path = makeDirectory($location);
    if (!$path) throw new Exception('File could not been created.');

    if (!empty($old)) {
        removeFile($location . '/' . $old);
        removeFile($location . '/thumb_' . $old);
    }
    $filename = uniqid() . time() . '.' . $file->getClientOriginalExtension();
    $image = Image::make($file);
    if (!empty($size)) {
        $size = explode('x', strtolower($size));
        $image->resize($size[0], $size[1], function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
    }
    $image->save($location . '/' . $filename);

    if (!empty($thumb)) {

        $thumb = explode('x', $thumb);
        Image::make($file)->resize($thumb[0], $thumb[1], function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        })->save($location . '/thumb_' . $filename);
    }
    return $filename;
}

function makeDirectory($path)
{
    if (file_exists($path)) return true;
    return mkdir($path, 0755, true);
}

function removeFile($path)
{
    return file_exists($path) && is_file($path) ? @unlink($path) : false;
}