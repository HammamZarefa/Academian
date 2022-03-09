<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ApplicantStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('applicant_statuses')->insert([
            ['name' => 'Applied'],
            ['name' => 'Reviewed'],
            ['name' => 'Screen'],
            ['name' => 'Need to schedule an interview'],
            ['name' => 'Interview scheduled'],
            ['name' => 'Interviewed'],
            ['name' => 'Offer'],
            ['name' => 'Hired'],
            ['name' => 'Candidate Widthdrew'],
            ['name' => 'On Hold'],
            ['name' => 'Reject'], 
        ]);
    }
}
