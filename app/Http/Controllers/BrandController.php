<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BrandController extends Controller
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
        // $brands = Brand::withTrashed()->get();
        $brands = Brand::all();
        // dd($brands[0]);
        return view('brand.brand', ['brands' => $brands]);
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
        $image->move(public_path('images/brand'), $imageName);

        $brand = new Brand();
        $brand->name = $request->name;
        $brand->user_id = Auth::user()->id;
        $brand->image = $imageName;
        $brand->save();
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function show(Brand $brand)
    {
        //    
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function edit(Brand $brand)
    {
        return view('brand.edit', ['brand' => $brand]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Brand $brand)
    {
        if ($request->file === null) {
            $brand->name = $request->name;
            $brand->user_id = Auth::user()->id;
            $brand->image = $request->currentImage;
            $brand->save();
            return redirect('brands');
            // return "{$brand->id}";
        } else {

            // return 'indi';
            $image = $request->file('file');
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('images/brand'), $imageName);
            $brand->name = $request->currentName;
            $brand->user_id = Auth::user()->id;
            $brand->image = $imageName;
            $brand->save();
            return redirect('brands');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy(Brand $brand)
    {
        if ($brand->shoes()->count()) {
            return redirect()->back()->withMessage('Cannot delete: this project has transactions');
        } else {
            $brand->delete();
            return redirect()->back();
        }
    }
}
