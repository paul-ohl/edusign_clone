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

Route::get('/sign/{id}', function (Request $request, string $id){
    $session = Session::find($id);
    if ($session == null) {
        abort(404);
    }
    if ($request->session()->has('qrcode-key') && $request->session()->get('qrcode-key') == $session->key) {
        return view('sign', ['id' => $id]);
    }
    $request_ts = now()->timestamp;
    $client_hash = request('hash');
    $offset = request('offset');
    if ($client_hash == null || $offset == null || $session->archived) {
        abort(401);
    }
    $request_closest_ts = floor($request_ts / $session->interval) * $session->interval + $offset;
    $request_previous_ts = $request_closest_ts - $session->interval;
    // $request_next_ts = $request_closest_ts + $session->interval;
    $server_hash = hash('sha1', $session->key.strval($request_closest_ts));
    $server_hash_previous = hash('sha1', $session->key.strval($request_previous_ts));
    // $server_hash_next = hash('sha1', $session->key.strval($request_next_ts));
    if ($client_hash != $server_hash
        && $client_hash != $server_hash_previous) {
        // && $client_hash != $server_hash_next) {
        // var_dump($client_hash, $server_hash, $server_hash_previous, $server_hash_next, $session->key);
        abort(401);
    }
    $request->session()->put('qrcode-key', $session->key);
    if (Auth::check()) {
        return view('sign', ['id' => $id]);
    } else {
        return redirect('/login');
    }
});

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
    if ($session == null || $session->archived) {
        abort(404);
    }
    if (Auth::user()->status != 'professeur') {
        abort(401);
    }
    $interval = request('refresh-interval');
    $session->key = Str::random(10);
    $session->interval = 10;
    $session->save();
    return response()->json($session->key);
});

Route::get('/sessions/archive/{id}', function($id) {
    $session = Session::find($id);
    if ($session == null) {
        abort(404);
    }
    $session_owner = $session->owner()->get()->first();
    $current_user_id = Auth::id();
    if ($session_owner->id != $current_user_id) {
        abort(401);
    }
    $session->archived = true;
    $session->save();
    return redirect('/sessions/'.$id);
});

Route::post('/sessions', [SessionsController::class, 'store'])->name('sessions.store');
Route::get('/sessions', function () { return redirect('/profile'); });


Route::get('/profile', function (Request $request) {
    return view('profile', [
        'user' => Auth::user(),
        'sessions' => Session::where('owner_id', Auth::user()->id)->get()
    ]);
})->middleware('auth');
