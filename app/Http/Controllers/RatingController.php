<?php
namespace App\Http\Controllers;

use App\Rating;
use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RatingController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, Order $order)
    {
        if (is_null($order->rating) && $order->customer_id == auth()->user()->id) {
            /*
             * Restrict a user from accessing the page if:
             * 1. Rating is already published
             * 2. The user is not the client of the order
             */

            return view('rating.create', compact('order'));
        } else {
            abort(404);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Order $order)
    {
        $validator = Validator::make($request->all(), [
            'comment' => 'sometimes|max:500',
            'number' => 'required'
        ], [
            'number.required' => 'Please choose a rating'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $request['order_id'] = $order->id;
        $request['user_id'] = auth()->user()->id;

        // Log user's activity
        $subject = anchor($order->number, route('orders_show', $order->id));
        logActivity($order, 'submited review on '. $subject);

        Rating::create($request->all());

        return redirect()->route('orders_show', $order->id)->withSuccess('Thank you for your feedback!');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Rating $rating
     * @return \Illuminate\Http\Response
     */
    public function show(Rating $rating)
    {}

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Rating $rating
     * @return \Illuminate\Http\Response
     */
    public function edit(Rating $rating)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Rating $rating
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rating $rating)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Rating $rating
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rating $rating)
    {
        //
    }
}
