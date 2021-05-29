<?php

namespace App\Http\Controllers;

use App\Models\DesignOrder;
use Illuminate\Contracts\Session\Session as SessionSession;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Session as FacadesSession;
use Session;

class DesignOrderController extends Controller
{
    public function custom_session(Request $request)
    {

        // dd($request->add_custom);
        // $designs = session( "design_id" => "1");
        // Session::forget('design_id');

        // $selected = session('custom');

        // $test = [session('custom')];
        // dd(session('custom'));


        // Session::forget('custom');
        // dd(session('custom'));
        // dd($design_order_lists);

        if (session('custom') == null) {
            // dd('tree');
            $design_order_lists = array();
            $design_order_lists = Arr::prepend($design_order_lists, $request->add_custom_design, $request->add_custom_part,);
            Session::put('custom', $design_order_lists);
        } else {
            // dd(session('custom'));
            $design_order_lists = session('custom');
            $design_order_lists = Arr::prepend($design_order_lists, $request->add_custom_design, $request->add_custom_part);
            Session::put('custom', $design_order_lists);
        }

        // dd(session('custom'));
        // dd(session('custom'));

        // $design_order_session = array_merge($test, $design_order_list);
        // $design_order_session = Session::push('custom', $design_order_list);
        /* if (session()->has('custom')) {
            $design_order_session = Session::push('custom', $design_order_list);
        } else {
            $design_order_session = Session::push('custom', $design_order_list);
        } */

        // $design_order_lists = session('test');
        // array_push('design_id','$request->custom_id');
        // dd($design_order_lists);

        return redirect()->back();
        // return redirect()->route('profile', [$user]);
    }

    public function remove_custom_part_session(Request $request)
    {
        $design_order_lists = session('custom');
        $design_order_remove = Arr::pull($design_order_lists, $request->remove_custom_design);
        // dd($design_order_lists);
        Session::put('custom', $design_order_lists);
        return redirect()->back();
    }

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
     * @param  \App\Models\DesignOrder  $designOrder
     * @return \Illuminate\Http\Response
     */
    public function show(DesignOrder $designOrder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DesignOrder  $designOrder
     * @return \Illuminate\Http\Response
     */
    public function edit(DesignOrder $designOrder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DesignOrder  $designOrder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DesignOrder $designOrder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DesignOrder  $designOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy(DesignOrder $designOrder)
    {
        //
    }
}
