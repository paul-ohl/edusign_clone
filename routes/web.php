<?php

use App\Http\Controllers\AddUser;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\User;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin', function () {
    return view('admin', ['users' => User::all() ]);
});

Route::get('/sign', function () {
    return view('sign');
});

Route::get('/login', function () {
    return view('login', ['users' => User::all() ]);
});

Route::post('/user/login', function(Request $request) {
    $userId = $request->input('user');
    Auth::loginUsingId($userId);
    return redirect('/profile');
});
Route::get('/user/logout', function(Request $request) {
    $request->session()->flush();
    return redirect('/login');
});

Route::get('/list', function () {
    return view('list', ['users' => User::all() ]);
});

Route::get('/session', function () {
    return view('session', ['users' => User::all() ]);
});

Route::get('/profile', function (Request $request) {
    return view('profile', ['current_user' => Auth::user() ]);
});

Route::post('/admin', [AddUser::class, 'store'])->name('users.store');
