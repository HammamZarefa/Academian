<?php
use Illuminate\Database\Seeder;
use App\Order;
use App\Services\BillService;
use App\User;

class BillsTableSeeder extends Seeder
{

    public $faker;

    function __construct()
    {
        $this->faker = \Faker\Factory::create();
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {        

        $users = User::role('staff')->has('unbilled_tasks')->get();

        if($users->count() > 0)
        {
            $user = $users->first();
            $billService = new BillService();
            $user->unbilled_tasks()
            ->orderBy('id','DESC')
            ->chunk(4, function($unbilled_tasks) use ($billService, $user) {

                $date = collect($unbilled_tasks->toArray())->max('created_at');
                $dt = new \DateTime($date);
                $max_order_date =  $dt->format('Y-m-d H:i:s');

                $bill = $billService->create([
                    'name' => $user->full_name,
                    'address' => $user->meta('address'),
                    'user_id' => $user->id
                ], $unbilled_tasks);

                // Log user's activity
                $subject = anchor($bill->number, route('bills_show', $bill->id));
                $log = logActivity($bill, 'requested for payment '. $subject, $bill->from);
                $log->created_at = $max_order_date;
                $log->save();

                if ($bill && $this->faker->randomElement([
                    1,
                    2
                ]) == 1) {
                    // Mark the bill as paid
                    $bill->paid = date("Y-m-d", strtotime($max_order_date));
                    $bill->save();
               
                    // Log user's activity
                    $user = User::role('admin')->get()->first();
                    $subject = anchor($bill->number, route('bills_show', $bill->id));
                    $log = logActivity($bill, 'marked as paid '. $subject, $user);
                    $log->created_at = $max_order_date;
                    $log->save();

                }


             });
        }


    }
}
