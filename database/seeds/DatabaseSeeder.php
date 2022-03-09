<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        $this->call([
            RolesTableSeeder::class,
            SettingsTableSeeder::class,  
            OrderStatusesTableSeeder::class,          
            ContentsTableSeeder::class, 
            RecruitmentSettingsSeeder::class
        ]);
        Schema::enableForeignKeyConstraints();
    }
}
