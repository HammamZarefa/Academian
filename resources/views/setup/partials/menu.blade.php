<div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
   <a class="nav-link" href="{{ route('settings_main_page') }}">@lang('General')</a>
   <a class="nav-link" href="{{ route('settings_currency_page') }}">@lang('Currency')</a>
   <a class="nav-link" href="{{ route('settings_staff_page') }}">@lang('Employees')</a>
   <a class="nav-link" href="{{ route('settings_recruitment') }}">@lang('Recruitment')</a>

   <div class="dropdown dropright">
      <a class="nav-link dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          @lang('Services & Pricing')
      </a>
      <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
         <a class="dropdown-item" href="{{ route('services_list') }}">@lang('Services')</a>
         <a class="dropdown-item" href="{{ route('service_category_list') }}">@lang('Services Category')</a>
         <a class="dropdown-item" href="{{ route('urgencies_list') }}">@lang('Urgencies')</a>
         <a class="dropdown-item" href="{{ route('work_levels_list') }}">@lang('Work Levels')</a>
         <a class="dropdown-item" href="{{ route('additional_services_list') }}">@lang('Additional Services')
         </a>
         <div class="dropdown-divider"></div>
         <a class="dropdown-item" href="{{ route('pricing') }}" target="_blank">
             @lang('View Generated Prices')
         </a>
      </div>
   </div>

      <div class="dropdown dropright">
      <a class="nav-link dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          @lang('Email')
      </a>
      <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
         <a class="dropdown-item" href="{{ route('settings_email_page') }}">@lang('Configuration')</a>
         <a class="dropdown-item" href="{{ route('send_test_email') }}">@lang('Send Test Email')</a>

      </div>
   </div>


   <a class="nav-link" href="{{ route('settings_logo_page') }}">@lang('Logo')</a>

   <div class="dropdown dropright">
      <a class="nav-link dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          @lang('Website Content')
      </a>
      <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
         <a class="dropdown-item" href="{{ route('settings_homepage') }}">@lang('Homepage')</a>
         <a class="dropdown-item" href="{{ route('settings_social_links') }}">@lang('Social Links')</a>
         <a class="dropdown-item" href="{{ route('settings_edit_content', 'how-it-works') }}">@lang('How it works')</a>
         <a class="dropdown-item" href="{{ route('settings_edit_content', 'faq') }}">@lang('FAQ')</a>
         <div class="dropdown-divider"></div>
         <a class="dropdown-item" href="{{ route('settings_edit_content', 'money-back-guarantee') }}">@lang('Money Back Guarantee')</a>
         <a class="dropdown-item" href="{{ route('settings_edit_content', 'privacy-policy') }}">@lang('Privacy Policy')</a>
         <a class="dropdown-item" href="{{ route('settings_edit_content', 'revision-policy') }}">@lang('Revision Policy')</a>
         <a class="dropdown-item" href="{{ route('settings_edit_content', 'disclaimer') }}">@lang('Disclaimer')</a>
         <a class="dropdown-item" href="{{ route('settings_edit_content', 'terms-and-conditions') }}">@lang('Terms & Condition')</a>
         <a class="dropdown-item" href="{{ route('google_analytics') }}">@lang('Google Analytics')</a>
         <a class="dropdown-item" href="{{ route('seo_page') }}">@lang('Website SEO')</a>
         <a class="dropdown-item" href="{{ route('custom_script_page') }}">@lang('Custom Script')</a>

         <div class="dropdown-divider"></div>
         <a class="dropdown-item" href="{{ route('clear_cache_page') }}">@lang('Clear Cache')</a>
      </div>
   </div>
   <a class="nav-link" href="{{ route('tags_list') }}">@lang('Tags')</a>
   <a class="nav-link" href="{{ route('settings_payment_gateways') }}">@lang('Payments Gateways')</a>
   <a class="nav-link" href="{{ route('offline_payment_methods') }}">@lang('Offline Payment Methods')</a>
   <a class="nav-link" href="{{ route('update_system_page') }}">@lang('System Update')</a>
</div>
