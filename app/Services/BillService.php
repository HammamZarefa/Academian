<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\NumberGenerator;
use App\Bill;
use App\BillItem;
use App\User;
use App\Exceptions\NoUnbilledWorkException;
use Illuminate\Database\Eloquent\Collection;

class BillService
{

    // name,address, note, user_id(optional),staff_invoice_number(optional)
    public function create($data, Collection $unbilled_tasks = null)
    {
        DB::beginTransaction();
        $status = false;

        try {

            // settling the user id
            $data['user_id'] = (isset($data['user_id'])) ? $data['user_id'] : auth()->user()->id;

            // Get the unbilled tasks
            if (empty($unbilled_tasks)) {
                $unbilled_tasks = User::find($data['user_id'])->unbilled_tasks()->get();
            }

            if ($unbilled_tasks->count() > 0) {
                // Calulate the total balance due
                $data['total'] = $unbilled_tasks->sum('staff_payment_amount');
            } else {

                throw new NoUnbilledWorkException('Sorry, there is no unbilled work');
            }

            // Generate the bill number
            $data['number'] = NumberGenerator::gen('App\Bill');

            if (
            // (isProvided() but isEmpty()) OR
            (isset($data['staff_invoice_number']) && empty($data['staff_invoice_number'])) || 
            // isNotProvided()
            ! isset($data['staff_invoice_number'])) {
                // If staff invoice number is not provided use the bill number instead
                $data['staff_invoice_number'] = str_replace('BILL-', '', $data['number']);
            }

            // Finally create the bill
            $bill = Bill::create($data);

            foreach ($unbilled_tasks as $order) {
                $item = new BillItem([
                    'order_id' => $order->id,
                    'total' => $order->staff_payment_amount
                ]);

                // Save the billing items
                $bill->items()->save($item);

                // Mark the order as billed by staff
                $order->billed = TRUE;
                $order->save();
            }

            DB::commit();

            return $bill;
        } catch (\Exception $e) {

            $status = false;
            DB::rollback();
        }

        return $status;
    }
}