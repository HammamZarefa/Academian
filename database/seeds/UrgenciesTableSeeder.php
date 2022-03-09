<?php

use Illuminate\Database\Seeder;
use App\Urgency;

class UrgenciesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Urgency::insert([
        	['value' => 3, 'type' => 'hours', 'percentage_to_add' => 20],
        	['value' => 6, 'type' => 'hours', 'percentage_to_add' => 18],
        	['value' => 12, 'type' => 'hours', 'percentage_to_add' => 16],
        	['value' => 24, 'type' => 'hours', 'percentage_to_add' => 14],
        	['value' => 2, 'type' => 'days', 'percentage_to_add' => 13],
        	['value' => 3, 'type' => 'days', 'percentage_to_add' => 12.5],
        	['value' => 4, 'type' => 'days', 'percentage_to_add' => 12],
        	['value' => 5, 'type' => 'days', 'percentage_to_add' => 11.5],
        	['value' => 7, 'type' => 'days', 'percentage_to_add' => 11],
        	['value' => 10, 'type' => 'days', 'percentage_to_add' => 10.5],
        	['value' => 14, 'type' => 'days', 'percentage_to_add' => 10],
        	['value' => 20, 'type' => 'days', 'percentage_to_add' => 9.5],
        ]);
    }
}
