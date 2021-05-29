<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Design;
use App\Models\Part;
use App\Models\Shoe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Session;

class ShoeController extends Controller
{
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
        $shoes = Shoe::all();
        // dd($shoes[0]->brand);
        $brands = Brand::all();
        // $brands = Brand::withTrashed()->get();

        // dd($brands);
        return view('shoes.shoe', ['shoes' => $shoes, 'brands' => $brands]);
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
        $image->move(public_path('images/shoes'), $imageName);

        $shoe = new Shoe();
        $shoe->user_id = Auth::user()->id;
        $shoe->brand_id = $request->brand;
        $shoe->name = $request->name;
        $shoe->image = $imageName;
        $shoe->price = $request->price;
        $shoe->save();
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Shoe  $shoe
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Shoe $shoe)
    {
        if (!Auth::user()) {
            return view('auth.login');
            // check if there's an account login
        }

        $design_id = 0; // get one data from session('custom')
        $sum = 0;
        if (session('custom')) {
            foreach (session('custom') as $selected) {
                $design_id = $selected;
                //send one data from session to $design_id
            }
            $design = Design::all()->where('id', '=', $design_id);

            foreach (session('custom') as $custom_design_id) {
                $sum_custom = Design::all()->where('id', '=', $custom_design_id);
                foreach ($sum_custom as $price) {
                    $sum += $price->price;
                }
            }
            $check_shoe_id = 0; // get the 
            foreach ($design as $shoe_id) {
                $check_shoe_id = $shoe_id;
            }
            if ($shoe->id != $check_shoe_id->shoe_id) {
                $request->session()->forget('custom');
                // dd('aw');13247.0
            }
        }
        // dd($sum);
        // dd($shoe->id
        // Session::forget('custom');
        $design_order_lists = session('custom');

        $shoeParts = $shoe->designs; //get all the design specified on shoe
        $designs = Design::all(); // get all design from table design
        $selectParts = Part::all(); //get all data from table parts

        return view('shoes.view-shoes', ['shoe' => $shoe, 'shoeParts' => $shoeParts, 'designs' => $designs, 'selectParts' => $selectParts, 'design_order_lists' => $design_order_lists, 'sum' => $sum]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Shoe  $shoe
     * @return \Illuminate\Http\Response
     */
    public function edit(Shoe $shoe)
    {
        // return view('shoes.view-shoes', ['shoe' => $shoe]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Shoe  $shoe
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Shoe $shoe)
    {
        if ($request->file === null) {
            $shoe->user_id = Auth::user()->id;
            $shoe->brand_id = $request->updateBrand;
            $shoe->name = $request->updatename;
            $shoe->price = $request->updateprice;
            $shoe->image = $request->intactCurrentImage;
            $shoe->save();
            return redirect('shoes');
            // return "{$shoe->id}";
        } else {


            $image = $request->file('file');
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('images/shoes'), $imageName);
            $shoe->name = $shoe->name;
            $shoe->user_id = Auth::user()->id;
            $shoe->image = $imageName;
            $shoe->save();
            return redirect('shoes');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Shoe  $shoe
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shoe $shoe)
    {
        if ($shoe->orders->count()) {
            return redirect()->back()->withMessage('Cannot delete: this project has transactions');
        }
        $shoe->delete();
        return redirect()->back();
    }
}
