<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;
use App\Content;
use App\Services\PaymentGatewaySettingsService;
use App\Setting;
use Carbon\Carbon;
use App\Services\LogoUploadService;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;
use Mews\Purifier\Facades\Purifier;
use App\Traits\SystemUpgrade;
use App\Traits\Settings\RecruitmentSettings;

class SettingsController extends Controller
{
    use SystemUpgrade;
    use RecruitmentSettings;
    
    function __destruct()
    {
        \Artisan::call("cache:clear");
    }

    public function general_information()
    {
        $data = [];

        $rec = $this->get_records([
            'company_name',
            'company_phone',
            'company_email',
            'company_address',
            'company_notification_email',           
            'number_of_revision_allowed',
            'hide_website'
        ]);

        return view('setup.general', compact('data', 'rec'));
    }

    public function update_general_information(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'company_name' => 'required',
            'company_phone' => 'required',
            'company_email' => 'required|email',
            'company_address' => 'required',
            'company_notification_email' => 'required|email',            
            'number_of_revision_allowed' => 'required|integer',
        ]);

        if ($validator->fails()) {

            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
      
        $request['hide_website'] = (isset($request->hide_website)) ? TRUE: NULL;

        $this->updateEnvKeys([
            ['key' => 'APP_NAME', 'value' => $request['company_name']],
            ['key' => 'DISABLE_WEBSITE', 'value' => $request['hide_website']]
        ]);

        $this->save_records($request->except(['_token', '_method', 'submit']));

        return redirect()->back()->withSuccess('Successfully updated');
    }

    public function currency()
    {
        $data['dropdowns'] = Setting::currency_dropdown();

        $rec = $this->get_records([
            'currency_symbol',
            'currency_code',
            'digit_grouping_method',
            'decimal_symbol',
            'thousand_separator'
        ]);

        return view('setup.currency', compact('data', 'rec'))->with('rec', $rec);
    }

    public function update_currency(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'currency_symbol' => 'required',
            'currency_code' => 'required|size:3',
            'digit_grouping_method' => 'required',
            'decimal_symbol' => 'required',
            'thousand_separator' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $this->save_records($request->except(['_token', '_method', 'submit']));

        return redirect()->back()->withSuccess('Successfully updated');
    }

    public function staff()
    {
        $data['enable_browsing_work'] = [
            'no' => 'No',
            'yes' => 'Yes'
        ];

        $data['staff_payment_types'] = [
            'fixed' => 'Fixed',
            'percentage' => 'Percentage'
        ];

        $rec = $this->get_records([
            'enable_browsing_work',
            'staff_payment_type',
            'staff_payment_amount'
        ]);

        return view('setup.staff', compact('data', 'rec'));
    }

    public function update_staff(Request $request)
    {
        $rules = [
            'enable_browsing_work' => 'required'
        ];

        if ($request->enable_browsing_work == 'yes') {
            $rules['staff_payment_amount'] = 'required|numeric|min:1';
            $rules['staff_payment_type'] = 'required|in:fixed,percentage';
        }

        $validator = Validator::make($request->all(), $rules, [
            'staff_payment_amount.required' => 'Payment amount is required',
            'staff_payment_amount.numeric' => 'Payment amount should be a valid number'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $this->save_records($request->except(['_token', '_method', 'submit']));

        return redirect()->back()->withSuccess('Successfully updated');
    }

    public function logo_page(Request $request)
    {
        return view('setup.logo');
    }

    public function update_logo(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'file' => 'required'
        ]);

        if ($validator->fails()) {

            return response()->json([
                'status'    => 2,
                'msg'       => implode(", ", $validator->errors()->all())

            ], 422);
        }

        return response()->json((new LogoUploadService())->upload($request));
    }

    private function getEnv($key)
    {
        if (DotenvEditor::keyExists($key)) {
            return DotenvEditor::getValue($key);
        }
        return NULL;
    }

    private function emailKeys()
    {
        return [
            'company_email_send_using' => 'MAIL_MAILER',
            'company_email_smtp_host' => 'MAIL_HOST',
            'company_email_smtp_port' => 'MAIL_PORT',
            'company_email_smtp_username' => 'MAIL_USERNAME',
            'company_email_smtp_password' => 'MAIL_PASSWORD',
            'company_email_encryption' => 'MAIL_ENCRYPTION',
            'company_email_from_address' => 'MAIL_FROM_ADDRESS',
            'company_email_mailgun_domain' => 'MAILGUN_DOMAIN',
            'company_email_mailgun_key' => 'MAILGUN_SECRET',
            'queue_connection' => 'QUEUE_CONNECTION',

        ];
    }

    function email()
    {

        $rec = new \stdClass();

        foreach ($this->emailKeys() as $key => $value) {

            $rec->{$key} = $this->getEnv($value);
        }

        $data['queue_connection_options'] = [
            'sync' => 'Sync',
            'database' => 'Database',
        ];


        $data['email_sending_options'] = [
            'smtp' => 'SMTP',
            'mailgun' => 'Mailgun',
            'log'   => 'Turn off email'
        ];

        return view('setup.email', compact('data'))->with('rec', $rec);
    }

    public function update_email(Request $request)
    {
        if ($request['company_email_send_using'] == 'mailgun') {
            $rules = [
                'company_email_mailgun_domain' => 'required',
                'company_email_mailgun_key' => 'required',
                'company_email_from_address' => 'required|email'
            ];
        } else {
            $rules = [
                'company_email_smtp_host' => 'required',
                'company_email_smtp_port' => 'required',
                'company_email_from_address' => 'required|email',
                'company_email_smtp_password' => 'required'
            ];
        }

        $msg = [

            'company_email_smtp_host.required' => 'Host is required',
            'company_email_smtp_port.required' => 'Port is required',
            'company_email_from_address.required' => 'Email from is required',
            'company_email_from_address.email' => 'Not a valid email address',
            'company_email_smtp_password.required' => 'SMTP password is required',
            'company_email_mailgun_domain.required' => 'Mailgun domain is required',
            'company_email_mailgun_key.required' => 'Mailgun key is required'
        ];

        $validator = Validator::make($request->all(), $rules, $msg);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        foreach ($this->emailKeys() as $input => $envKey) {

            $keys[] = ['key' => $envKey, 'value' => $request[$input]];
        }


        $this->updateEnvKeys($keys);

        \Artisan::call("config:clear");

        return redirect()->back()->withSuccess('Successfully updated');
    }

    private function updateEnvKeys($keys)
    {
        DotenvEditor::setKeys($keys);
        DotenvEditor::save();

        \Artisan::call("cache:clear");
        \Artisan::call("config:clear");
    }

    function test_email()
    {
        return view('setup.test_email');
    }

    function send_test_email(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'test_email_address' => 'required|email'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {

            Mail::to($request->test_email_address)->send(new TestMail());

            return redirect()->back()->withSuccess('Email sent');
        } catch (\Swift_TransportException $e) {

            return redirect()->back()->withFail('Could not send the email. Please check your email settings');
        }
    }

    function paymentGateways(Request $request, PaymentGatewaySettingsService $settingSerice)
    {
        $config = config('paymentgateways');

        if ($settingSerice->isValidGateway($request->gateway, $config['gateways'])) {
            abort(404);
        }
        $data = $settingSerice->recordsForSettingsPage($request->gateway, $config);

        return view('setup.payment.gateway', compact('data'));
    }

    function content(Request $request, $slug)
    {
        $content = Content::where('slug', $slug)->get();

        if ($content->count() > 0) {
            $content = $content->first();
        }

        return view('setup.content')->with('content', $content);
    }

    function update_content(Request $request, $slug)
    {
        $validator = Validator::make($request->all(), [
            'description' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withFail('You cannot leave the content empty');
        }

        $content = Content::where('slug', $slug)->get();

        if ($content->count() > 0) {
            $content = $content->first();

            $content->description = $request->description;
            $content->save();

            return redirect()->back()->withSuccess('Successfully updated');
        } else {
            return redirect()->back()->withFail('Update was not successfull');
        }
    }

    function homepage()
    {
        $data['fields'] = Setting::homepage_form_elements();
        $data['records'] = [];

        $records = Setting::whereIn('option_key', array_keys($data['fields']))->orderBy('id', 'ASC')->get();

        if (count($records) > 0) {
            $data['records'] = $records->toArray();
        }

        return view('setup.homepage', compact('data'));
    }

    function update_homepage(Request $request)
    {
        $fields = Setting::homepage_form_elements();

        foreach ($fields as $key => $value) {
            $rules[$key] = 'required';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $inputs = $request->all();

        $fields['homepage_last_updated_at'] = NULL;

        $inputs['homepage_last_updated_at'] = Carbon::now()->format('Y-m-d H:i:s');

        foreach ($inputs as $key => $value) {
            if (in_array($key, array_keys($fields))) {
                $this->save_records([
                    $key => $value
                ], NULL, TRUE);
            }
        }

        Cache::forget('homepage');

        return redirect()->back()->withSuccess('Successfully updated');
    }


    function social_links()
    {
        $data['fields'] = Setting::socialNetworks();
        $data['records'] = [];
        $records = Setting::whereIn('option_key', array_keys($data['fields']))->get();
        if (count($records) > 0) {
            $data['records'] = $records->toArray();
        }
        return view('setup.social_links', compact('data'));
    }

    function update_social_links(Request $request)
    {
        $fields = Setting::socialNetworks();
        $inputs = $request->all();

        foreach ($inputs as $key => $value) {
            if (in_array($key, array_keys($fields))) {
                $this->save_records([
                    $key => $value
                ], NULL, TRUE);
            }
        }
        return redirect()->back()->withSuccess('Successfully updated');
    }

    function website_custom_scripts()
    {
        $data['records'] = $this->get_records([
            'website_header_script',
            'website_footer_script'
        ]);

        return view('setup.website_scripts', compact('data'));
    }

    function update_website_custom_scripts(Request $request)
    {
        $this->save_records([
            'website_header_script' => $request->website_header_script,
            'website_footer_script' => $request->website_footer_script
        ]);

        return redirect()->back()->withSuccess('Successfully updated');
    }

    function google_analytics()
    {
        $data['records'] = $this->get_records([
            'google_analytics_tracking_code'
        ]);

        return view('setup.google_analytics', compact('data'));
    }

    function update_google_analytics(Request $request)
    {
        $this->save_records([
            'google_analytics_tracking_code' => $request->input('google_analytics_tracking_code')
        ]);

        return redirect()->back()->withSuccess('Successfully updated');
    }

    function seo()
    {
        $fields = Setting::seoInputFields();

        $record = $this->get_records($fields['ungrouped']);

        $data = $fields['grouped'];
        return view('setup.seo', compact('data', 'record'));
    }

    function update_seo(Request $request)
    {
        $fields = Setting::seoInputFields('ungrouped');

        $data = [];

        foreach ($fields as $field) {
            $data[$field] = $request->{$field};
        }

        if (is_array($data) && count($data) > 0) {
            $this->save_records($data, true, true);
        }

        return redirect()->back()->withSuccess('Successfully updated');
    }

    function clear_cache_page()
    {
        return view('setup.clear_cache');
    }

    function clear_cache(Request $request)
    {
        Cache::flush();
        return redirect()->back()->withSuccess('Cache cleared');
    }    

    private function get_records($keys)
    {
        if (is_array($keys)) {
            $records = Setting::whereIn('option_key', $keys)->get();
        } else {
            $records = Setting::where('option_key', $keys)->get();
        }

        if (count($records) > 0) {
            $records = $records->toArray();
            $rec = new \stdClass();
            foreach ($records as $row) {
                $rec->{$row['option_key']} = $row['option_value'];
            }

            return $rec;
        }

        return NULL;
    }

    private function save_records($data, $auto_load_disabled = NULL, $sanitize = NULL)
    {
        foreach ($data as $key => $value) {

            $obj = Setting::updateOrCreate([
                'option_key' => $key
            ]);

            if ($sanitize) {
                $obj->option_value = Purifier::clean(trim($value));
            } else {
                $obj->option_value = trim($value);
            }

            if ($auto_load_disabled) {
                $obj->auto_load_disabled = TRUE;
            } else {
                $obj->auto_load_disabled = NULL;
            }

            $obj->save();
        }
    }
}
