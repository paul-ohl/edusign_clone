<?php

namespace App\Http\Controllers;

use App\Models\SessionSign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionSignController extends Controller
{
    public function store(Request $request)
    {
        $user_id = Auth::id();
        $session_id = $request->input('session_id');

        $sessionSign = new SessionSign();
        $sessionSign->user_id = $user_id;
        $sessionSign->session_id = $session_id;
        dd($sessionSign);
        $sessionSign->save();

        return redirect('/sessions/'.$session_id);
    }
}
