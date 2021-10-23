<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;

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

Auth::routes();

Route::group(['middleware' => ['auth']], function () {
    Route::get('users/fetch_data', [UserController::class, 'fetch_data']);
    Route::delete('/roles/{id}', [UserController::class, 'destroy']);
    Route::get('roles/fetch_data', [RoleController::class, 'fetch_data']);
    Route::delete('/roles/{id}', [RoleController::class, 'destroy']);
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
});
