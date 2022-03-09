<?php

use Illuminate\Database\Seeder;
use App\WorkLevel;

class WorkLevelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        WorkLevel::insert([
        	['name' => 'High School', 'percentage_to_add' => 2.3],
        	['name' => 'College', 'percentage_to_add' => 3.3],
        	['name' => 'Undergraduate', 'percentage_to_add' => 4.3],
        	['name' => 'Masters', 'percentage_to_add' => 8.3],
        	['name' => 'Ph.D.', 'percentage_to_add' => 10.3],
        ]);
    }
}
