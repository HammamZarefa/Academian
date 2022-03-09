<?php

use Illuminate\Database\Seeder;
use App\User;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            [
                'role'  => 'admin', 
                'email' => 'admin@demo.com',
            ],
        ];
      

        foreach ($types as $row) 
        {
            $user = new User();
            $user->first_name = 'Admin';
            $user->last_name  = 'Lastname';
            $user->email = $row['email'];            
            $user->email_verified_at = now();
            $user->password = bcrypt('123456');
            $user->save();
            // Assign Role
            $user->assignRole($row['role']);             
        }

        

    }

    
}
