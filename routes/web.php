<?php

use App\Http\Controllers\AddUser;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\SessionSignController;
use App\Http\Controllers\UsersController;
use App\Models\User;
use App\Models\Session;
use App\Models\SessionSign;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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

Route::get('/sign/{id}', function (string $id){
    $session = Session::find($id);
    $request_ts = now()->timestamp;
    $client_hash = request('hash');
    $offset = request('offset');
    if ($session == null) {
        abort(404);
    } else if ($client_hash == null || $offset == null) {
        abort(401);
    }
    $request_closest_ts = floor($request_ts / $session->interval) * $session->interval + $offset;
    $request_previous_ts = $request_closest_ts - $session->interval;
    $server_hash = base64_encode(hex2bin(hash('sha1', $session->key.strval($request_closest_ts))));
    $server_hash_previous = base64_encode(hex2bin(hash('sha1', $session->key.strval($request_previous_ts))));
    // dd($client_hash, $server_hash, $server_hash_previous);
    if ($client_hash == $server_hash || $client_hash == $server_hash_previous) {
        return view('sign', ['id' => $id] );
    } else {
        abort(401);
    }
})->middleware('auth');

Route::post('/sign/{id}', [SessionSignController::class, 'store']);

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
    if ($session == null) {
        abort(404);
    }
    $users_that_signed = SessionSign::where('session_id', $id)->pluck('user_id');
    return view('session', [
        'users' => User::all(),
        'user' => Auth::user(),
        'users_that_signed' => $users_that_signed,
        'owner' => $session->owner()->get()->first(),
        'session' => $session,
    ]);
})->middleware('auth');
Route::get('/sessions/sign/{id}', function($id){
    $students = User::where('status', 'etudiant')->select('id', 'name')->get();
    $users_that_signed = SessionSign::where('session_id', $id)->pluck('user_id');
    foreach ($students as $user) {
        if ($users_that_signed->contains($user->id)) {
            $user->signed = true;
        } else {
            $user->signed = false;
        }
    }
    return response()->json($students);
});
Route::get('/sessions/get-key/{id}', function($id) {
    $session = Session::find($id);
    if ($session == null) {
        abort(404);
    }
    $interval = request('refresh-interval');
    $session->key = Str::random(10);
    $session->interval = 10;
    $session->save();
    return response()->json($session->key);
});

Route::post('/sessions', [SessionsController::class, 'store'])->name('sessions.store');
Route::get('/sessions', function () { return redirect('/profile'); });


Route::get('/profile', function (Request $request) {
    return view('profile', [
        'user' => Auth::user(),
        'sessions' => Session::where('owner_id', Auth::user()->id)->get()
    ]);
})->middleware('auth');
