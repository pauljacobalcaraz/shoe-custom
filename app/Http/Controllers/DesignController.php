<?php

namespace App\Http\Controllers;

use App\Models\Design;
use App\Models\DesignOrder;
use Illuminate\Contracts\Session\Session as SessionSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;

class DesignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd('$designs');
        // $designs = Design::all();

        // return view('shoes.view-shoes', ['designs' => $designs]);
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
        $image = $request->file('file');
        $imageName = time() . '.' . $image->extension();
        $image->move(public_path('images/designs'), $imageName);

        $design = new Design();
        $design->user_id = Auth::user()->id;
        $design->part_id = $request->part;
        $design->shoe_id = $request->shoe_id;
        $design->name = $request->name;
        $design->image = $imageName;
        $design->price = $request->price;
        $design->save();
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Design  $design
     * @return \Illuminate\Http\Response
     */
    public function show(Design $design)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Design  $design
     * @return \Illuminate\Http\Response
     */
    public function edit(Design $design)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Design  $design
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Design $design)
    {

        if ($request->file === null) {
            $design->user_id = Auth::user()->id;
            $design->part_id = $request->updatePart;
            $design->name = $request->updatename;
            $design->price = $request->updateprice;
            $design->image = $request->intactCurrentImage;
            $design->save();
            return redirect()->back();
            // return "{$shoe->id}";
        } else {


            dd($design->name);
            $image = $request->file('file');
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('images/designs'), $imageName);
            $design->name = $design->name;
            $design->user_id = Auth::user()->id;
            $design->image = $imageName;
            $design->save();
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Design  $design
     * @return \Illuminate\Http\Response
     */
    public function destroy(Design $design)
    {

        // $design_orders = DesignOrder::all()->where('order_id', '=', $design->id)->count();
        // dd($design_orders);
        if ($design_orders = DesignOrder::all()->where('order_id', '=', $design->id)->count()) {
            return redirect()->back()->withMessage('Cannot delete: this project has transactions');
        }
        $design->delete();
        return redirect()->back();
    }
    public function custom_session(Request $request)
    {
        //
        // $request->session()->push('key', '$request->add_custom');
        // Session::push('key', $request->add_custom);
        // $value = $request->session()->get('key');
        // dd($value);
        // return 'session mo pagod';
        // dd($design);
        // dd($value);
    }
}
