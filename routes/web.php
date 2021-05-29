<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\DesignController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PartController;
use App\Http\Controllers\ShoeController;
use App\Http\Controllers\DesignOrderController;
use DeepCopy\TypeFilter\ShallowCopyFilter;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// Route::get('/brands', [BrandController::class, 'index']);
// Route::post('/brands', [BrandController::class, 'store']);

Route::resource('/brands', BrandController::class);

Route::resource('/shoes', ShoeController::class);
Route::post('/custom', [DesignOrderController::class, 'custom_session']);
Route::get('/custom', [DesignOrderController::class, 'custom_session']);
Route::post('/remove_custom_part', [DesignOrderController::class, 'remove_custom_part_session']); //remove part on customs
// Route::resource('shoes.parts', PartController::class)->shallow();
Route::resource('/parts', PartController::class);
Route::resource('/designs', DesignController::class);
Route::resource('/orders', OrderController::class);
// Route::get('/custom-designs', ['uses' => ''])
