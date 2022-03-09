<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReferralSourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('referral_sources')->insert([
            ['name' => 'Indeed', 'display_order' => 1],
            ['name' => 'LinkedIn', 'display_order' => 2],
            ['name' => 'Facebook', 'display_order' => 3],
            ['name' => 'Craiglist', 'display_order' => 4],
            ['name' => 'Friend', 'display_order' => 5],
            ['name' => 'Others', 'display_order' => 6],            
        ]);
    }
}
