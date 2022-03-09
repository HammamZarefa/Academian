<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Bill extends Model
{
    use SoftDeletes;

    protected $casts = [
        'paid' => 'date'
    ];
    
    protected $fillable = [
        'number',
        'staff_invoice_number',
        'user_id',
        'total',
        'name',
        'address',
        'note'
    ];

    function items()
    {
        return $this->hasMany('App\BillItem');
    }

    function from()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    static function admin_dropdown()
    {
        $data['staff_list'] = [
            '' => 'Select'
        ] + User::role('staff')->orderBy('first_name', 'ASC')
            ->select(DB::raw('first_name as name'), 'id')
            ->pluck('name', 'id')
            ->toArray();

        $data['bill_status_list'] = [
            '' => 'All',
            'paid' => 'Paid',
            'unpaid' => 'Unpaid'
        ];

        return $data;
    }

    static function statistics($staff_id = NULL)
    {
        $bills['unpaid'] = [
            'total' => 0,
            'count' => 0
        ];
        $bills['paid'] = [
            'total' => 0,
            'count' => 0
        ];

        $select = DB::raw("(CASE WHEN paid IS NULL THEN 'unpaid' ELSE 'paid' END) as status, count(*) as count, SUM(total) AS total");

        $records = Bill::select($select)->groupBy('paid')->get();

        if ($records->count() > 0) {
            foreach ($records as $row) {
                $bills[$row->status]['total'] = $row->total;
                $bills[$row->status]['count'] = $row->count;
            }
        }

        return $bills;
    }
}
