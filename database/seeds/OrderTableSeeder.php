<?php

use Illuminate\Database\Seeder;

use App\Order;
use App\Service;
use App\Urgency;
use App\WorkLevel;
use App\User;
use App\AdditionalService;
use App\OrderAdditionalService;
use App\Attachment;
use App\SubmittedWork;
use App\Rating;
use App\Comment;
use App\Services\CalculatorService;
use App\Services\OrderService;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Faker\Generator as Faker;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\PushNotification;
use App\Enums\PriceType;
use App\Services\PaymentRecordService;

class OrderTableSeeder extends Seeder
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
        // Schema::disableForeignKeyConstraints();
        // $this->truncateSubmittedWork();
        // Order::query()->truncate();
        // OrderAdditionalService::query()->truncate();
        // Attachment::query()->truncate();
        // Schema::enableForeignKeyConstraints();

        $this->createPreviousMonthsOrders();

        $orders = [

            ['status_id' => ORDER_STATUS_SUBMITTED_FOR_APPROVAL, 'number_of_order' => 5],
            ['status_id' => ORDER_STATUS_REQUESTED_FOR_REVISION, 'number_of_order' => 5],
            ['status_id' => ORDER_STATUS_IN_PROGRESS, 'number_of_order' => 5],
            ['status_id' => ORDER_STATUS_COMPLETE, 'number_of_order' => 20],
            ['status_id' => ORDER_STATUS_NEW, 'number_of_order' => 5],
            ['status_id' => ORDER_STATUS_SUBMITTED_FOR_APPROVAL, 'number_of_order' => 1],
            ['status_id' => ORDER_STATUS_REQUESTED_FOR_REVISION, 'number_of_order' => 1],
            ['status_id' => ORDER_STATUS_IN_PROGRESS, 'number_of_order' => 1],
            ['status_id' => ORDER_STATUS_COMPLETE, 'number_of_order' => 1],
            ['status_id' => ORDER_STATUS_NEW, 'number_of_order' => 1],
        ];

        // For Predefined customer first.
        foreach ($orders as $row) {
            for ($i = 1; $i <= $row['number_of_order']; $i++) {

                $order = $this->createOrder($row['status_id'], NULL, 3);
                $this->afterCreatingOrder($order);
            }
        }

        foreach ($orders as $row) {
            for ($i = 1; $i <= $row['number_of_order']; $i++) {

                $order = $this->createOrder($row['status_id']);
                $this->afterCreatingOrder($order);
            }
        }

        PushNotification::insert([
            //Admin
            ['user_id' => 1, 'number' => 5],
            //Staff/Writer
            ['user_id' => 2, 'number' => 3],
        ]);
    }

    private function createOrder(int $order_status_id, $order_date = NULL, $customer_id = NULL): Order
    {
        $faker = $this->faker;

        $services = Service::pluck('id');
        $urgencies = Urgency::pluck('id');
        $workLevels = WorkLevel::pluck('id');
        $users = User::doesntHave('roles')->pluck('id');     
        

        $calculator = new CalculatorService();
        if ($customer_id) {
            $data['customer_id'] = $customer_id;
        } else {
            $data['customer_id'] = $faker->randomElement($users->toArray());
        }

        $data['title'] = $faker->text(30);
        $data['instruction'] = $faker->paragraph(5);

        $data['service_id'] = $faker->randomElement($services->toArray());
        $service = Service::find($data['service_id']);
        $additionalServices= $service->additionalServices()->pluck('additional_service_id');

        $data['urgency_id'] = $faker->randomElement($urgencies->toArray());
        $urgency = Urgency::find($data['urgency_id']);
        $data['work_level_id'] = $faker->randomElement($workLevels->toArray());

        if(count($additionalServices->toArray()) > 0)
        {
            $adService = AdditionalService::find($faker->randomElement($additionalServices->toArray()));
            $data['added_services'] = [$adService->toArray()];
        }
        else
        {
            $data['added_services'] = [];
        }
        

        if ($service->price_type_id == PriceType::Fixed) {
            $data['quantity'] = 1;
        } else {
            $data['quantity'] = $service->minimum_order_quantity * $faker->randomElement([1, 2]);
        }

        if ($service->price_type_id == PriceType::PerPage) {
            $data['spacing_type'] = $faker->randomElement([
                'double',
                'single'
            ]);
        }
        $data['dead_line'] = $this->get_urgency_date($urgency->type, $urgency->value, $order_date);

        $data = array_merge($data, $calculator->calculatePrice($data));
        $data['cart_total'] = $calculator->orderTotal($data);
        $data['staff_payment_amount'] = $calculator->staffPaymentAmount($data['cart_total']);
        $data['order_status_id'] = $order_status_id;


        $payment = new PaymentRecordService();
        $gateway = $faker->randomElement(['Paypal Smart Checkout', 'Stripe', 'Bank Transfer']);
        $payment->store($data['customer_id'], $gateway, $data['cart_total'], $faker->isbn13());

        Order::reguard();

        $orderService = new OrderService();
        $order = $orderService->create($data);

        if ($order_date) {

            $order->created_at = $order_date;
            $order->save();
        }

        $this->notification('NewOrder', $order);
        return $order;
    }

    private function assign_to_staff($order)
    {
        $users = User::role('staff')->pluck('id');
        $order->staff_id = $this->faker->randomElement($users->toArray());
        $order->save();

        // Log user's activity
        $admin = User::role('admin')->get()->first();

        $subject = anchor($order->number, route('orders_show', $order->id));
        $to = anchor($order->assignee->full_name, route('user_profile', $order->assignee->id));
        $log = logActivity($order, 'assigned ' . $subject . ' to ' . $to, $admin);
        $log->created_at = $order->created_at;
        $log->save();

        $this->notification('TaskAssignedToYou', $order);
    }

    private function submit_work(Order $order)
    {
        $submittedWork =  SubmittedWork::create([
            'name' => $this->createZipFile(),
            'display_name' => $this->faker->word,
            'message' => $this->faker->paragraph,
            'order_id' => $order->id,
            'user_id' => $order->staff_id
        ]);


        $submittedWork->created_at = $order->created_at->addMinutes(25)->toDateTimeString();
        $submittedWork->save();



        // Log user's activity
        $subject = anchor($order->number, route('orders_show', $order->id));
        $log = logActivity($order, 'submitted work for ' . $subject, $order->assignee);
        $log->created_at = $submittedWork->created_at;
        $log->save();

        $this->notification('SubmittedTask', $order, $submittedWork);

        return $submittedWork;
    }

    private function accept_task_by_customer(Order $order)
    {
        $order->order_status_id = ORDER_STATUS_COMPLETE;
        $order->save();

        // Log user's activity
        $subject = anchor($order->number, route('orders_show', $order->id));
        $log = logActivity($order, 'accepted delivered item for ' . $subject, $order->assignee);
        $log->created_at = $order->created_at->addMinutes(2)->toDateTimeString();
        $log->save();

        $this->notification('OrderDeliveryAccepted', $order);
    }

    private function request_revision_by_customer(Order $order)
    {
        $work = $order->latest_submitted_work();

        $work->needs_revision = TRUE;
        $work->customer_message = $this->faker->paragraph;
        $work->created_at = $order->created_at->addMinutes(30)->toDateTimeString();
        $work->save();


        // Log user's activity
        $subject = anchor($order->number, route('orders_show', $order->id));
        $log = logActivity($order, 'requested for revision ' . $subject, $order->assignee);
        $log->created_at = $order->created_at;
        $log->save();

        $this->notification('ClientRequestedForRevision', $order, $work);
    }

    private function leave_a_review(Order $order)
    {
        // Log user's activity
        $subject = anchor($order->number, route('orders_show', $order->id));
        $log = logActivity($order, 'submited review on ' . $subject, $order->customer);
        $log->created_at = $order->created_at->addMinutes(40)->toDateTimeString();
        $log->save();

        $rating = Rating::create([
            'order_id' => $order->id,
            'user_id' => $order->customer_id,
            'number' => $this->faker->randomElement(range(1, 5)),
            'comment' => $this->faker->paragraph
        ]);

        $rating->created_at = $log->created_at;
        $rating->save();

        return $rating;
    }

    private function post_a_comment(Order $order)
    {
        if ($order->staff_id) {
            $user_ids = [
                $order->customer_id,
                $order->staff_id
            ];
        } else {
            $user_ids = [
                $order->customer_id
            ];
        }

        $comment = new Comment();
        $comment->body = $this->faker->paragraph;
        $comment->user_id = $this->faker->randomElement($user_ids);
        $order->comments()->save($comment);

        $comment->created_at = $order->created_at->addMinutes(15)->toDateTimeString();
        $comment->save();

        // Log user's activity
        $subject = anchor($order->number, route('orders_show', $order->id));
        $log = logActivity($order, 'posted comment ' . $subject, $comment->user);
        $log->created_at = $comment->created_at;
        $log->save();

        $this->notification('NewComment', $order, $comment);

        return $comment;
    }

    // -------------------------------------- Helpers
    private function afterCreatingOrder(Order $order)
    {
        $order->followers()->attach(1); //Admin
        /*
         * NEW
         * empty
         */

        /*
         * IN_PROGRESS
         * Assigned to a user
         */

        /*
         * SUBMITTED_FOR_APPROVAL
         * Assigned to a user
         * Submit Work
         */

        /*
         * REQUESTED_FOR_REVISION
         * Assigned to a user
         * Submit Work
         * Post comment
         * request_revision_by_customer
         *
         */

        /*
         * COMPLETE
         * Assigned to a user
         * Post comment
         * Submit Work
         * Aceept Task by customer
         * Leave a review
         */
        switch ($order->order_status_id) {
            case ORDER_STATUS_NEW:

                break;
            case ORDER_STATUS_IN_PROGRESS:
                $this->assign_to_staff($order);
                break;
            case ORDER_STATUS_SUBMITTED_FOR_APPROVAL:
                $this->assign_to_staff($order);
                $this->submit_work($order);
                break;
            case ORDER_STATUS_REQUESTED_FOR_REVISION:
                $this->assign_to_staff($order);
                $this->post_a_comment($order);
                $this->submit_work($order);
                $this->request_revision_by_customer($order);
                break;
            case ORDER_STATUS_COMPLETE:
                $this->assign_to_staff($order);
                $this->post_a_comment($order);
                $this->submit_work($order);
                $this->accept_task_by_customer($order);
                $this->leave_a_review($order);
                break;

            default:
                // code...
                break;
        }
    }

    private function createZipFile()
    {
        $faker = $this->faker;
        $file = 'attachments/' . $faker->randomNumber . '.txt';
        $file_full_path = storage_path('app/' . $file);
        \File::put($file_full_path, 'dummy content');

        $zip = new ZipArchive();

        $zip_file = 'attachments/' . $faker->word . ".zip";

        $zip_file_path = storage_path('app/' . $zip_file);

        if ($zip->open($zip_file_path, ZIPARCHIVE::CREATE) != TRUE) {
            die("Could not open archive");
        }
        $zip->addFile($file_full_path, $faker->randomNumber . '.txt');

        // close and save archive
        $zip->close();

        if (Storage::exists($file)) {
            Storage::delete($file);
        }

        return $zip_file;
    }

    private function truncateSubmittedWork()
    {
        $works = SubmittedWork::all();

        foreach ($works as $work) {
            if (Storage::exists($work->name)) {
                Storage::delete($work->name);
            }
        }

        SubmittedWork::query()->truncate();
    }

    private function createPreviousMonthsOrders()
    {
        $number_of_months = 5;

        for ($i = 1; $i <= $number_of_months; $i++) {

            $start = now()->subMonths($i)->startofMonth();

            for ($j = 1; $j <= 5; $j++) {
                $randomDays = rand(0, 28);
                $date = $start->copy()->addDays($randomDays)->toDateTimeString();

                $data[] = [
                    'status_id' =>  ORDER_STATUS_COMPLETE,
                    'number_of_order' => 3,
                    'date' => $date
                ];
            }
        }

        usort($data, function ($a, $b) {
            return strtotime($a["date"]) - strtotime($b["date"]);
        });

        foreach ($data as $row) {
            for ($i = 1; $i <= $row['number_of_order']; $i++) {

                $order = $this->createOrder($row['status_id'], $row['date']);
                $this->afterCreatingOrder($order);
            }
        }
    }

    private function get_urgency_date($type, $value, $order_date = NULL)
    {
        if ($order_date && !empty($order_date)) {
            $now = Carbon::parse($order_date);
        } else {
            $now = Carbon::now();
        }


        $now = ($type == 'hours') ? $now->addHours($value) : $now->addDays($value);

        return $now->format('Y-m-d H:i:s');
    }


    function notification($type, $order, $subject = NULL)
    {
        if ($type == 'NewOrder') {
            $date       = $order->created_at;
            $message    = 'New order - ' . $order->number;
            $url        = route('orders_show', $order->id);
            $notifiable_id = 1; //Admin
        }

        if ($type == 'TaskAssignedToYou' && $order->staff_id) {
            $date       = $order->created_at->addMinutes(1)->toDateTimeString();
            $message    = 'You have a new task';
            $url        = route('orders_show', $order->id);
            $notifiable_id = $order->staff_id;
        }

        if ($type == 'SubmittedTask') {
            $submittedTask = $subject;

            $message    = $order->number . ' - is ready for download';
            $url        = route('orders_show', $order->id);
            $notifiable_id = 1; //Admin
            $date = $submittedTask->created_at;
        }

        if ($type == 'OrderDeliveryAccepted') {
            $multiple = [
                [
                    'message'    => 'Delivery complete - ' . $order->number,
                    'url'        => route('orders_show', $order->id),
                    'notifiable_id' => 1, //Admin
                ],
                [
                    'message'    => 'Delivery complete - ' . $order->number,
                    'url'        => route('orders_show', $order->id),
                    'notifiable_id' => $order->staff_id,
                ]
            ];
            $date = $order->created_at->addMinutes(2)->toDateTimeString();
        }

        if ($type == 'ClientRequestedForRevision') {
            $work       = $subject;
            $date       = $work->created_at;
            $multiple   = [
                [
                    'message'    => 'Revision request for ' . $order->number,
                    'url'        => route('orders_show', $order->id),
                    'notifiable_id' => 1, //Admin
                ],
                [
                    'message'    => 'Revision request for ' . $order->number,
                    'url'        => route('orders_show', $order->id),
                    'notifiable_id' => $order->staff_id,
                ]
            ];
        }

        if ($type == 'NewComment') {
            $comment = $subject;
            $date       = $comment->created_at;
            $name   = $comment->user->full_name;
            $message    = $name . ' comment on ' . $order->number;
            $url = route('orders_show', $order->id);

            $multiple = [
                [
                    'message'    => $message,
                    'url'        => $url,
                    'notifiable_id' => 1, //Admin
                ],
            ];

            // If comment is by customer
            if (($comment->user_id == $order->customer_id) && $order->staff_id) {

                $multiple[1] = [
                    'message'    => $message,
                    'url'        => $url,
                    'notifiable_id' => $order->staff_id,
                ];
            }
        }


        if (isset($multiple)) {
            foreach ($multiple as $row) {
                extract($row);
                $this->insertNotification($type, $notifiable_id, $message, $url, $date);
            }
        } else {
            $this->insertNotification($type, $notifiable_id, $message, $url, $date);
        }
    }

    private function insertNotification($type, $notifiable_id, $message, $url, $date)
    {
        $data = [
            'id' => $this->faker->regexify('[A-Za-z0-9]{20}'),
            'type' => 'App\Notifications\\' . $type,
            'notifiable_type' => 'App\User',
            'notifiable_id' => $notifiable_id,
            'data' => json_encode(['message' => $message, 'url' => $url]),
            'created_at' => $date
        ];

        DB::table('notifications')->insert($data);
    }
}
