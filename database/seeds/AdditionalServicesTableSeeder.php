<?php

use Illuminate\Database\Seeder;
use App\AdditionalService;

class AdditionalServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         AdditionalService::insert([
        	[
        		'type' => 'fixed',
        		'name' => 'Plagiarism report', 
        		'description' => 'You will receive a detailed plagiarism report in PDF format.',
        		'rate' => 9.99,
        	],
        	[
        		'type' => 'fixed',
        		'name' => 'Editor\'s check', 
        		'description' => 'Your paper will pass an additional editor\'s check, to make sure it\'s polished to perfection.',
        		'rate' => 4.99,
        	],
        	[
        		'type' => 'fixed',
        		'name' => 'Copy of sources', 
        		'description' => 'You will get extracts from books or articles or direct links to the materials used in your paper.',
        		'rate' => 9.99,
        	],
        	[
        		'type' => 'fixed',
        		'name' => '1-page summary', 
        		'description' => '1-page summary of your paper to get the whole idea and present it to your instructor.',
        		'rate' => 19.99,
        	],
        	[
        		'type' => 'fixed',
        		'name' => 'Priority support', 
        		'description' => 'Be first in line to get all of your questions or concerns addressed by first-class professionals.',
        		'rate' => 9.99,
        	],
        	
        ]);
    }
}
