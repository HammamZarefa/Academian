<div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
   <a class="nav-link" href="{{ route('settings_main_page') }}">General</a>
   <a class="nav-link" href="{{ route('settings_currency_page') }}">Currency</a>
   <a class="nav-link" href="{{ route('settings_staff_page') }}">Employees</a>
   <a class="nav-link" href="{{ route('settings_recruitment') }}">Recruitment</a>   

   <div class="dropdown dropright">
      <a class="nav-link dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      Services & Pricing
      </a>
      <div class="dropdown-menu" aria-labelledby="dropdownMenuLink"> 
         <a class="dropdown-item" href="{{ route('services_list') }}">Services</a>
         <a class="dropdown-item" href="{{ route('service_category_list') }}">Services Category</a>
         <a class="dropdown-item" href="{{ route('urgencies_list') }}">Urgencies</a>
         <a class="dropdown-item" href="{{ route('work_levels_list') }}">Work Levels</a>
         <a class="dropdown-item" href="{{ route('additional_services_list') }}">Additional Services
         </a>
         <div class="dropdown-divider"></div>
         <a class="dropdown-item" href="{{ route('pricing') }}" target="_blank">
            View Generated Prices
         </a>
      </div>
   </div>

      <div class="dropdown dropright">
      <a class="nav-link dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      Email
      </a>
      <div class="dropdown-menu" aria-labelledby="dropdownMenuLink"> 
         <a class="dropdown-item" href="{{ route('settings_email_page') }}">Configuration</a>
         <a class="dropdown-item" href="{{ route('send_test_email') }}">Send Test Email</a>
    
      </div>
   </div>


   <a class="nav-link" href="{{ route('settings_logo_page') }}">Logo</a>
   
   <div class="dropdown dropright">
      <a class="nav-link dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      Website Content
      </a>
      <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
         <a class="dropdown-item" href="{{ route('settings_homepage') }}">Homepage</a>
         <a class="dropdown-item" href="{{ route('settings_social_links') }}">Social Links</a>
         <a class="dropdown-item" href="{{ route('settings_edit_content', 'how-it-works') }}">How it works</a>
         <a class="dropdown-item" href="{{ route('settings_edit_content', 'faq') }}">FAQ</a>
         <div class="dropdown-divider"></div>
         <a class="dropdown-item" href="{{ route('settings_edit_content', 'money-back-guarantee') }}">Money Back Guarantee</a>
         <a class="dropdown-item" href="{{ route('settings_edit_content', 'privacy-policy') }}">Privacy Policy</a>
         <a class="dropdown-item" href="{{ route('settings_edit_content', 'revision-policy') }}">Revision Policy</a>
         <a class="dropdown-item" href="{{ route('settings_edit_content', 'disclaimer') }}">Disclaimer</a>
         <a class="dropdown-item" href="{{ route('settings_edit_content', 'terms-and-conditions') }}">Terms & Condition</a>         
         <a class="dropdown-item" href="{{ route('google_analytics') }}">Google Analytics</a>
         <a class="dropdown-item" href="{{ route('seo_page') }}">Website SEO</a>  
         <a class="dropdown-item" href="{{ route('custom_script_page') }}">Custom Script</a> 		 
   
         <div class="dropdown-divider"></div>
         <a class="dropdown-item" href="{{ route('clear_cache_page') }}">Clear Cache</a>
      </div>
   </div>
   <a class="nav-link" href="{{ route('tags_list') }}">Tags</a>
   <a class="nav-link" href="{{ route('settings_payment_gateways') }}">Payments Gateways</a>
   <a class="nav-link" href="{{ route('offline_payment_methods') }}">Offline Payment Methods</a>
   <a class="nav-link" href="{{ route('update_system_page') }}">System Update</a>
</div>