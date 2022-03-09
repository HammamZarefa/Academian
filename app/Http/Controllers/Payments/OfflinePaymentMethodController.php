<?php

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use App\OfflinePaymentMethod;
use Illuminate\Support\Str;

class OfflinePaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('setup.payment.offline.index');
    }

    public function datatable(Request $request)
    {
        $method = OfflinePaymentMethod::orderBy('name', 'ASC');

        if (!$request->include_inactive_items) {
            $method->whereNull('inactive');
        }

        return Datatables::eloquent($method)
            ->editColumn('name', function ($offlinePaymentMethod) {

                return '<a href="' . route('offline_payment_method_edit', $offlinePaymentMethod->slug) . '">' . $offlinePaymentMethod->name . '</a>';
            })
            ->addColumn('status', function ($offlinePaymentMethod) {
                return ($offlinePaymentMethod->inactive) ? 'Inactive' : 'Active';
            })
            ->addColumn('action', function ($offlinePaymentMethod) {

                return '<a class="btn btn-sm btn-danger delete-item" href="' . route('offline_payment_method_delete', $offlinePaymentMethod->id) . '"><i class="fas fa-minus-circle"></i></a>';
            })
            ->rawColumns([
                'name',
                'status',
                'action'
            ])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $method = new \StdClass();
        $method->settings = new \StdClass();
        return view('setup.payment.offline.create', compact('method'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|unique:offline_payment_methods',
            'description' => 'required',
            'instruction' => 'nullable|max:500',
            'success_message' => 'required|max:255',
        ];

        if ($request->requires_transaction_number) {
            $rules['reference_field_label'] = 'required';
        }
        if ($request->requires_uploading_attachment) {
            $rules['attachment_field_label'] = 'required';
        }
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $request['slug'] = Str::slug($request->name, '-');
        $request['settings'] = [
            'requires_transaction_number' => $request->requires_transaction_number,
            'requires_uploading_attachment' => $request->requires_uploading_attachment,
            'reference_field_label' => $request->reference_field_label,
            'attachment_field_label' => $request->attachment_field_label,
        ];

        $request['inactive'] = (isset($request->inactive)) ? TRUE : NULL;

        $paymentMethod = OfflinePaymentMethod::create($request->all());

        // Log user's activity        
        logActivity($paymentMethod, 'created a new offline payment method - ' . $request->name);

        return redirect()->back()->withSuccess('Created a new payment method');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(OfflinePaymentMethod $method)
    {
        return view('setup.payment.offline.create', compact('method'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required|unique:offline_payment_methods,id,' . $id,
            'description' => 'required',
            'instruction' => 'nullable|max:255',
            'success_message' => 'required|max:255',
        ];

        if ($request->requires_transaction_number) {
            $rules['reference_field_label'] = 'required';
        }
        if ($request->requires_uploading_attachment) {
            $rules['attachment_field_label'] = 'required';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $request['slug'] = Str::slug($request->name, '-');
        $request['settings'] = [
            'requires_transaction_number' => $request->requires_transaction_number,
            'requires_uploading_attachment' => $request->requires_uploading_attachment,
            'reference_field_label' => $request->reference_field_label,
            'attachment_field_label' => $request->attachment_field_label,
        ];

        $request['inactive'] = (isset($request->inactive)) ? TRUE : NULL;

        $paymentMethod = OfflinePaymentMethod::find($id);
        $paymentMethod->fill($request->all());
        $paymentMethod->update();

        // Log user's activity        
        logActivity($paymentMethod, 'updated offline payment method' . $paymentMethod->name);

        return redirect()->route('offline_payment_method_edit', $paymentMethod->slug)->withSuccess('Updated the work level');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $redirect = redirect()->route('offline_payment_methods');
        try {
            $paymentMethod = OfflinePaymentMethod::find($id);
            $paymentMethod->delete();
            $redirect->withSuccess('Successfully deleted');
        } catch (\Illuminate\Database\QueryException $e) {

            $redirect->withFail('Cannot be deleted as it is associated with one or multiple orders');
        } catch (\Exception $e) {
            $redirect->withFail('Could not perform the requested action');
        }

        return $redirect;
    }
}
