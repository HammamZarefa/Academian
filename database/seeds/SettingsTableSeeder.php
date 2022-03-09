<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Setting;

class SettingsTableSeeder extends Seeder
{
    public $faker;

    function __construct(){

        $this->faker = \Faker\Factory::create();
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       DB::table('settings')->truncate();

       

        // Settings
        $settings = [
            'company_name'                      => 'ProWriters', 
            'company_logo'                      => 'public/uploads/logo.png',          
            'company_phone'                     => '541 754-3010',
            'company_address'                   => $this->faker->address,         
            'company_country'                   => 'USA',
            'company_email'                     => 'support@prowriters.com',
            'company_notification_email'        => 'support@prowriters.com',
            'company_about'                   => 'Firmament morning sixth subdue darkness creeping gathered divide our let god moving. Moving in fourth air night bring upon it beast let you dominion likeness open place day great.',
            'enable_paypal'                   	=> TRUE,
            'enable_creditcard'                 => TRUE,
            'facebook'							=> 'http://www.facebook.com/microelephant',
            'twitter'							=> 'http://www.twitter.com',
            'instagram'							=> 'http://www.instagram.com',
            'linkedin'							=> 'http://www.linkedin.com',          	
          	'footer_text'						=> 'All rights reserved | Microelephant',
            'system_starting_year'              => date("Y"),
            'time_zone'                         => 'America/New_York',          
         
            'decimal_symbol'                    => '.',
            'thousand_separator'                => ',',
            'digit_grouping_method'             => '1',
            'currency_symbol'                   => '$',
            'currency_code'                     => 'USD',
            'enable_browsing_work'              => 'yes',
            'staff_payment_amount'              => 1.5,
            'staff_payment_type'                => 'percentage',
            'number_of_revision_allowed'        => '-1',
            'prowriters_version'				=> get_software_version()

        ];


        
        foreach ($settings as $key=>$value)
        {
            DB::table('settings')->insert(['option_key' => $key, 'option_value' => $value]);
        }

        foreach ($this->homepage_contents() as $key=>$value)
        {
            DB::table('settings')->insert([
                'option_key' => $key, 'option_value' => $value, 'auto_load_disabled' => TRUE
            ]);
        }


        $this->copyLogo();
        $this->setupWebPageSeo();
        
    }

    private function setupWebPageSeo()
    {
        $pages = Setting::seoInputFields('grouped'); 
     
        foreach ($pages as $page => $inputs) 
        {
            //title
            $data[$inputs[0]] = ucwords(str_replace('_',' ', $page));
            // description
            $data[$inputs[1]] = $this->faker->text(100);
            //keyworkds
            $data[$inputs[2]] = implode(",", $this->faker->words($nb = 5, $asText = false));    
           
        }

        if(count($data) > 0)
        {
            foreach ($data as $key => $value) {
               Setting::create([
                    'option_key' => $key,
                    'option_value' => $value,
                    'auto_load_disabled' => TRUE
               ]);
            }
        }        

    }

    private function copyLogo()
    {
        $file   = 'dummy-content/logo.png'; 
        $logo   = 'public/uploads/logo.png';
        
        if(Storage::exists($logo))
        {
            Storage::delete($logo);             
        }

        Storage::copy($file, $logo); 
    }


    public function homepage_contents()
    {
        return [
            'hero_title_1'=> 'Top Grade Writing Service', 
            'hero_button_text'=> 'Get an instant Quote',
            'section_1_title'=> 'High-Quality Papers from Expert Writers',

            'section_1_content'=> 'Our team creates college research papers and essays. We take into account every single requirement mentioned by the customer: deadline, subject, topic, level, number of pages, etc. You describe your assignment - we do the whole job! Our experts can complete any academic task within the given period of time. We ensure high-quality essay writing and editing services. And yet, the prices are reasonable for every student. If you wish to save your day, choose an essay writer from our team or let our experts select the author for you based on your requirements. It’s easy to order from our website.',

        'section_2_title'=> 'Types of Works We Offer',
        'section_2_sub_title'=> 'Get professional assistance from our experts. Our writers only write English language essays and papers.',

        'section_3_title'=> 'How it works',
        'section_3_sub_title'=> 'Our writers deliver most of the essays ahead of schedule. It takes 4 simple steps to buy your custom paper:',

        'how_it_works_step_1'=> 'Fill out the order form:',
        'how_it_works_step_2'=> 'Proceed with payment:',
        'how_it_works_step_3'=> 'Communicate:',
        'how_it_works_step_4'=> 'Get your finished order:',


        'how_it_works_step_1_content'=> 'Submit your order details with the potential writer (subject, type of work, level, format, size, and deadline).',
        'how_it_works_step_2_content'=> 'Pay for our essay writer service. Pick one of the available safe methods online: PayPal, or debit/credit card.',
        'how_it_works_step_3_content'=> 'Contact the assigned expert at any time you need to solve different problems and watch the process.',
        'how_it_works_step_4_content'=> 'Receive your essay before the deadline. Check the quality. Revisions are possible during 2 weeks after the order delivery.',

        
        'section_4_title'=> 'Features that make us special',
        'section_4_para_1_title'=> '100% Confidentiality',
        'section_4_para_1_content'=> 'Information about customers is confidential and never disclosed to third parties. Information about customers is confidential and never disclosed to third parties.',

        'section_4_para_2_title'=> 'Timely Delivery',
        'section_4_para_2_content'=> 'No missed deadlines – 97% of assignments are complete in time.',
        
        'section_4_para_3_title'=> 'Original Writing',
        'section_4_para_3_content'=> 'We complete all papers from scratch. You can get a plagiarism report.',
        
        'section_4_para_4_title'=> 'Plagiarism-Free Content',
        'section_4_para_4_content'=> 'We follow a strict anti-plagiarism policy thus all the papers are written from scratch. We scan every paper for plagiarism with a special licensed software to ensure 100% originality and proper citation before sending it to our clients.',

        'order_page_link_text'=> 'Calculate your order',
        

        ]   ;
    }
   

function email_template_header()
    {
        return '<!doctype html>
<html>
   <head>
      <meta name="viewport" content="width=device-width" />
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
      <style>
         body {
         background-color: #f6f6f6;
         font-family: sans-serif;
         -webkit-font-smoothing: antialiased;
         font-size: 14px;
         line-height: 1.4;
         margin: 0;
         padding: 0;
         -ms-text-size-adjust: 100%;
         -webkit-text-size-adjust: 100%;
         }
         table {
         border-collapse: separate;
         mso-table-lspace: 0pt;
         mso-table-rspace: 0pt;
         width: 100%;
         }
         table td {
         font-family: sans-serif;
         font-size: 14px;
         vertical-align: top;
         }
         /* -------------------------------------
         BODY & CONTAINER
         ------------------------------------- */
         .body {
         background-color: #f6f6f6;
         width: 100%;
         }
         /* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */
         .container {
         display: block;
         margin: 0 auto !important;
         /* makes it centered */
         max-width: 680px;
         padding: 10px;
         width: 680px;
         }
         /* This should also be a block element, so that it will fill 100% of the .container */
         .content {
         box-sizing: border-box;
         display: block;
         margin: 0 auto;
         max-width: 680px;
         padding: 10px;
         }
         /* -------------------------------------
         HEADER, FOOTER, MAIN
         ------------------------------------- */
         .main {
         background: #fff;
         border-radius: 3px;
         width: 100%;
         }
         .wrapper {
         box-sizing: border-box;
         padding: 20px;
         }
         .footer {
         clear: both;
         padding-top: 10px;
         text-align: center;
         width: 100%;
         }
         .footer td,
         .footer p,
         .footer span,
         .footer a {
         color: #999999;
         font-size: 12px;
         text-align: center;
         }
         hr {
         border: 0;
         border-bottom: 1px solid #f6f6f6;
         margin: 20px 0;
         }
         /* -------------------------------------
         RESPONSIVE AND MOBILE FRIENDLY STYLES
         ------------------------------------- */
         @media only screen and (max-width: 620px) {
         table[class=body] .content {
         padding: 0 !important;
         }
         table[class=body] .container {
         padding: 0 !important;
         width: 100% !important;
         }
         table[class=body] .main {
         border-left-width: 0 !important;
         border-radius: 0 !important;
         border-right-width: 0 !important;
         }
         }
      </style>
   </head>
   <body class="">
      <table border="0" cellpadding="0" cellspacing="0" class="body">
      <tr>
         <td> </td>
         <td class="container">
            <div class="content">
            <!-- START CENTERED WHITE CONTAINER -->
            <table class="main">
            <!-- START MAIN CONTENT AREA -->
      <tr>
         <td class="wrapper">
            <table border="0" cellpadding="0" cellspacing="0">
      <tr>
         <td>';
    }
   

   function email_template_footer()
   {
     return '</td>
</tr>
</table>
</td>
</tr>
<!-- END MAIN CONTENT AREA -->
</table>
<!-- START FOOTER -->
<div class="footer">
   <table border="0" cellpadding="0" cellspacing="0">
      <tr>
         <td class="content-block">
            <span>@[company_name]</span>
         </td>
      </tr>
      <tr>
         <td class="content-block">
            <span>@[company_logo]</span>
         </td>
      </tr>
   </table>
</div>
<!-- END FOOTER -->
<!-- END CENTERED WHITE CONTAINER -->
</div>
</td>
<td> </td>
</tr>
</table>
</body>
</html>';
   }
}
