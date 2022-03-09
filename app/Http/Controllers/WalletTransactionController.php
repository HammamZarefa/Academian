<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\WalletTransaction;
use Yajra\DataTables\Facades\DataTables;

class WalletTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('wallet.transactions');
    }

    public function datatable(Request $request)
    {
        if ($request->user_id) {
            $transactions = WalletTransaction::whereHas('wallet', function ($q) use ($request) {
                return $q->where('user_id', $request->user_id);
            });
        } else {
            $transactions = WalletTransaction::with([
                'wallet'
            ]);
        }
        $transactions->orderBy('id', 'DESC');

        return Datatables::eloquent($transactions)
            ->addColumn('date', function ($transaction) {
                return date("d-M-Y", strtotime($transaction->created_at));
            })
            ->addColumn('user', function ($transaction) {
                return anchor_link($transaction->wallet->user->full_name, route('user_profile', $transaction->wallet->user_id));
            })
            ->editColumn('amount', function ($transaction) {
                return format_money($transaction->amount);
            })
            ->addColumn('reference', function ($transaction) {

                return $transaction->getReferenceLink();
            })
            ->rawColumns([
                'date',
                'amount',
                'user',
                'reference'

            ])
            ->make(true);
    }

    public function myWalletTransactionsDatatable(Request $request)
    {
        $transactions = WalletTransaction::whereHas('wallet', function ($q) {
            return $q->where('user_id', auth()->user()->id);
        })->orderBy('id', 'DESC');

        return Datatables::eloquent($transactions)
            ->addColumn('date', function ($transaction) {
                return date("d-M-Y", strtotime($transaction->created_at));
            })

            ->editColumn('amount', function ($transaction) {
                return format_money($transaction->amount);
            })
            ->editColumn('balance', function ($transaction) {
                return format_money($transaction->balance);
            })
            ->addColumn('reference', function ($transaction) {

                return $transaction->getReferenceLink();
            })
            ->rawColumns([
                'date',
                'amount',
                'balance',
                'reference'

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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
