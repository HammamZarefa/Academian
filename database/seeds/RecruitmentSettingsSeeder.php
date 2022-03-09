<?php

use Illuminate\Database\Seeder;
use App\Setting;

class RecruitmentSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->save_records([
            'disable_writer_application' => null,
            'show_writer_application_link_website_top_menu' => 1,
            'writer_application_page_link_title' => 'Become a writer',
            'writer_application_page_title' => 'Become a writer - Join us',
            'writer_application_form_title' => 'Join our team',
            'writer_application_form_subtitle' => 'Please thoroughly review our list of qualifications before applying.',
            'writer_application_page_content' => $this->getContent(),
            'writer_application_form_success_message' => 'Thank you for submitting your application',
        ]);
    }

    private function save_records($data)
    {
        foreach ($data as $key => $value) {

            $obj = Setting::updateOrCreate([
                'option_key' => $key
            ]);

            $obj->option_value = trim($value);
            $obj->save();
        }
    }

    private function getContent()
    {
       return '<h2><strong>About </strong></h2><p><span style="color: rgb(58, 58, 58); background-color: rgb(255, 255, 255);">We ensure our customers receive work of the highest quality by supporting our essay writers throughout every stage of the process, from assignment to delivery. We choose to work exclusively with individuals committed to clarity and transparency, who are passionate about helping others learn, grow and better understand the world around them.</span></p><p><br></p><h2><strong>Qualified candidates must have:</strong></h2><ul><li>a flawless grasp of MLA, APA and CPS formatting.</li><li>a bachelor\'s degree, or be in active pursuit of one.</li><li>a 3.3 GPA or better.</li><li>a clear understanding of how to conduct online research.</li><li>the ability to cheerfully accept constructive criticism.</li><li>a consistent commitment to being responsive and reliable.</li><li>Microsoft Office.</li></ul><h2><br></h2><h2><strong>Perks of the job:</strong></h2><ul><li>Choose your own assignments and work when you want, where you want.</li><li>Enjoy working as part of an elite team of skilled and supportive colleagues.</li><li>Write what you know and learn what you don’t on topics ranging from marketing and economics to philosophy and politics.</li><li>We offer among the highest rates in the industry, averaging $25 an hour.</li><li>Payment is delivered conveniently through direct deposit or PayPal.</li></ul><p><br></p><p><br></p>';
    }
}
