<?php

namespace App\Http\Controllers;

use App\Models\SessionSign;
use Illuminate\Http\Request;

class SessionSignController extends Controller
{
    public function store(Request $request)
    {
        $user_id = \Auth::id();
        $session_id = $request->input('session_id');

        $sessionSign = new SessionSign();
        $sessionSign->user_id = $user_id;
        $sessionSign->session_id = $session_id;

        $sessionSign->save();

        return redirect('/sessions/'.$session_id);
    }
}
