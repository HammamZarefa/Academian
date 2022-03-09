<?php

use App\PriceType;
use Illuminate\Database\Seeder;

class PriceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PriceType::insert([
            ['name' => 'Fixed'],
            ['name' => 'Per Word'],
            ['name' => 'Per Page'],
        ]);
    }
}
