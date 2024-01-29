<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UrlShortnerController;
use App\Http\Controllers\PackageController;


Route::get('/', function () {
    return view('home');
});

Auth::routes();


Route::group(['middleware' => ['auth', 'verified']], function () {
    
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/urlShortnerForm', [UrlShortnerController::class, 'viewPage'])->name('urlShortnerForm');
Route::post('/createShortner', [UrlShortnerController::class, 'createShortner'])->name('createShortner');
Route::get('/showDataTable', [UrlShortnerController::class, 'showDataTable'])->name('showDataTable');
Route::delete('/deleteURL/{id}', [UrlShortnerController::class, 'deleteURL' ])->name('deleteURL');
Route::get('/editURLForm/{id}', [UrlShortnerController::class, 'editURLForm' ])->name('editURLForm');
Route::post('/updateURLForm', [UrlShortnerController::class, 'updateURLForm'])->name('updateURLForm');
Route::get('/packageForm', [PackageController::class, 'index' ])->name('packageForm');
Route::post('/upgradePlan', [PackageController::class, 'upgradePlan' ])->name('upgradePlan');
});