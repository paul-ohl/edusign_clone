<?php

use App\Http\Controllers\AddUser;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\SessionSignController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Session;
use Illuminate\Support\Facades\Auth;

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

Route::get('/admin', [UsersController::class, 'create']);
Route::post('/admin', [UsersController::class, 'store']);
Route::delete('/users/{user}', [UsersController::class, 'destroy']);

Route::get('/login', function () {
    if(!session()->has('url.intended'))
    {
        session(['url.intended' => url()->previous()]);
    }
    return view('login', ['users' => User::all() ]);
})->name('login');

Route::get('/admin', function () {
    return view('admin', ['users' => User::all() ]);
});

Route::get('/sign/{session_id}', [SessionSignController::class, 'store'])->middleware('auth');

Route::post('/user/login', function(Request $request) {
    $userId = $request->input('user');
    Auth::loginUsingId($userId);
    return redirect(session()->get('url.intended'));
});
Route::get('/user/logout', function(Request $request) {
    $request->session()->flush();
    return redirect('/login');
});

Route::get('/sessions/{id}', function (string $id) {
    $session = Session::find($id);
    return view('session', [
        'users' => User::all(),
        'user' => Auth::user(),
        'owner' => $session->owner()->get()->first(),
        'session' => $session,
    ]);
})->middleware('auth');

Route::post('/sessions', [SessionsController::class, 'store'])->name('sessions.store');
Route::get('/sessions', function () { return redirect('/profile'); });

Route::get('/profile', function (Request $request) {
    return view('profile', [
        'user' => Auth::user(),
        'sessions' => Session::where('owner_id', Auth::user()->id)->get()
    ]);
})->middleware('auth');
