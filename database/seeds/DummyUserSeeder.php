<?php

use Illuminate\Database\Seeder;
use App\User;
use App\UserRecord;
use App\Tag;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class DummyUserSeeder extends Seeder
{
    public $faker;
    public $lastPhotoUsed;

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
        //User::truncate();
        
        $faker = \Faker\Factory::create();

        $types = [
            [
                'role'  => 'admin', 
                'email' => 'admin@demo.com',
                'photo' => 'uploads/avatars/XzA1MjM1MjEuanBn.jpg',
            ],
            [
                'role'  => 'staff', 
                'email' => 'writer@demo.com',  
                'photo' => 'uploads/avatars/5eac6d75500a4_1588358517.png',              
            ],
            [
                'role'  => NULL, 
                'email' => 'customer@demo.com',
                'photo' => 'uploads/avatars/XzA3Mjk0MjUuanBn.jpg', 
            ]
        ];

        foreach ($types as $row) 
        {
            $user = new User();
            $user->first_name = $faker->firstName;
            $user->last_name = $faker->lastName;
            $user->email = $row['email'];
            $user->photo = $row['photo'];
            $user->email_verified_at = now();
            $user->password = bcrypt('123456');
            $user->save();

            $user->created_at = now()->subMonths(6)->startofMonth()->toDateTimeString();
            $user->save();
            
            if(isset($row['role']) && $row['role'])
            {
                 // Assign role 'admin' to the user
                $user->assignRole($row['role']);
            }

            if(isset($row['role']) && $row['role'] == 'staff')
            {
                $this->createSkills($faker, $user);
            }

            $this->createUserRecord($faker, $user);           
            
           
        }

        $this->createPreviousMonthsUsers();

        factory('App\User', $faker->randomElement(range(20,25)) )->create([
            'created_at'    => Carbon::now()->subDays(7),
            'photo'         => $this->getCustomerPhoto()
        ]);

        $this->handleProfilePhotos();

    }

    private function createUserRecord($faker, $user)
    {
        $keys = [
                'preferred_payment_method' => 'Paypal',
                'payment_method_details' => $faker->email,
                'bio' => $faker->paragraph,
                'address' => $faker->address,
            ];

            foreach ($keys as $key=>$value) 
            {
                $rec = UserRecord::create([
                    'user_id'       => $user->id,
                    'option_key'    => $key,      

                ]); 
                $rec->option_value =  $value;
                $rec->save();     
            }
    }

    private function handleProfilePhotos()
    {
        $files = Storage::allFiles('dummy-content');
        
        foreach ($files as $key => $file) {

            $photo = str_replace('dummy-content/avatar/', 'public/uploads/avatars/', $file);
            
            if(!Storage::exists($photo))
            {
                Storage::copy($file, $photo);    
            }
            
        }
    }

    private function createSkills($faker, $user)
    {
        Tag::insert([
        ['name' => 'Accounting'],
        ['name' => 'Advertising/Public Relations'],
        ['name' => 'Alternative Dispute Resolution'],
        ['name' => 'Anthropology'],
        ['name' => 'Archaeology'],
        ['name' => 'Architecture'],
        ['name' => 'Business'],
        ['name' => 'Communications'],
        ['name' => 'Computer Science'],
        ['name' => 'Conflict of Laws'],
        ['name' => 'Contract Law'],
        ['name' => 'Econometrics'],
        ['name' => 'Design'],
        ['name' => 'English Literature'],
        ['name' => 'Environmental Sciences'],
        ['name' => 'Food and Nutrition'],
        ['name' => 'Geography'],
        ['name' => 'Health Psychology'],
        ['name' => 'Intellectual Property Law']]);

         $tags = Tag::pluck('id');

         $user->tag_sync($faker->randomElements($tags->toArray(), 8));      
    }

    private function createPreviousMonthsUsers()
    {
        for ($i=1; $i <= 5 ; $i++) { 
            
            $start = now()->subMonths($i)->startofMonth();
            
            for ($j=1; $j <= 5; $j++) { 
                $randomDays = rand(0, 28);
                $date = $start->copy()->addDays($randomDays)->toDateTimeString();

                $data[] = [                    
                    'number_of_users' => 3, 
                    'date' => $date
                ] ;
            }
        }

        usort($data, function($a, $b) {
          return strtotime($a["date"]) - strtotime($b["date"]);
        });

        foreach ($data as $row) {

            factory('App\User', $row['number_of_users'])->create([
                    'created_at'    => $row['date'],
                    'photo'         => $this->getCustomerPhoto()
            ]);
        }
        
        return $data;
    }

    private function getCustomerPhoto()
    {
        $collection = [
            'XzA0MjM2NTIuanBn.jpg',
            'XzA0NTM3MjQuanBn.jpg',
            'XzA0NzQwNzYuanBn.jpg',
            'XzA1MjM1MjEuanBn.jpg',
            'XzA2ODQ0MjAuanBn.jpg',
            'XzA3MjQwODkuanBn.jpg',
            'XzA4MDg4NjcuanBn.jpg',
            'XzA4OTY3MTYuanBn.jpg',
            'XzAxMjk2NjcuanBn.jpg',
        ];

        if($this->lastPhotoUsed && in_array($this->lastPhotoUsed, $collection))
        {
            if (($key = array_search($this->lastPhotoUsed, $collection)) !== false) {
                unset($collection[$key]);
            }
        }

        $photo = $this->faker->randomElement($collection);
        
        $this->lastPhotoUsed = $photo;
        
        return 'uploads/avatars/'. $photo ;
   
    }
}
