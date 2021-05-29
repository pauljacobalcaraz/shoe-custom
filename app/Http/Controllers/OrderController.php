<?php

namespace App\Http\Controllers;

use App\Models\Design;
use App\Models\DesignOrder;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // SESSION['designs']= array();
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Auth::user()) {
            return view('auth.login');
            // check if there's an account login
        }
        if (Auth::user()->account_type != null) {
            //('admin');
            $orders = Order::all();
            // dd($brands[0]);
            return view('order.order', ['orders' => $orders]);
        } else {
            $orders = Order::all()->where('user_id', '=', Auth::user()->id);

            // dd('client');
            // dd($brands[0]);
            return view('order.order', ['orders' => $orders]);
        }
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
    public function store(Request $request, Order $order)
    {
        $order = new Order();
        $order->user_id =  Auth::user()->id;
        $order->shoe_id =  $request->shoe_id;
        $order->status_id =  1; // 1 pending, 2 received, 3 done
        $order->save();
        if (session('custom')) { // check if 'custom' is empty or existed
            $design_order_lists = session('custom');
            foreach ($design_order_lists as $design_order_list => $value) {
                $design_order = new DesignOrder();
                $design_order->order_id = $order->id;
                $design_order->design_id = $value;
                $design_order->save();
            } //save all designs that inside the session

            $request->session()->forget('custom'); // forget the custom session after purchase
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        if (!Auth::user()) {
            return view('auth.login');
            // check if there's an account login
        }
        $designs = Design::all();
        $orders = Order::all();
        // $design_order = DB::table('design_orders')->get();
        // dd($design_order);
        $sum = 0;
        $design_order = DesignOrder::all()->where('order_id', '=', $order->id);
        return view('order.view-order', ['order' => $order, 'designs' => $designs, 'orders' => $orders, 'design_order' => $design_order, 'sum' => $sum]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        // dd($order->status->id);
        if ($order->status->id == 1)
            $order->status_id = $request->received;
        else {
            $order->status_id = $request->done;
        }
        $order->save();
        return redirect('/orders');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        // dd($order->id);
        DB::table('design_orders')->where('order_id', '=', $order->id)->delete();
        $order->delete();
        return redirect('/orders');
    }
}
