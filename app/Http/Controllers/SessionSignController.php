<?php

namespace App\Http\Controllers;

use App\Models\SessionSign;
use App\Models\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionSignController extends Controller
{
    public function store(Request $request)
    {
        $current_user = Auth::user();
        $user_id = $current_user->id;
        $session_id = $request->input('session_id');
        $user_signed = SessionSign::where('session_id', $session_id)->where('user_id', $user_id)->get();

        $session = Session::find($session_id);
        if ($session == null) {
            abort(404);
        }
        if (!$request->session()->has('qrcode-key')
            || $request->session()->get('qrcode-key') != $session->key
            || $current_user->status != 'etudiant'
            || $user_signed->count() > 1) {
            return redirect('/sessions/'.$session_id);
        }

        $sessionSign = new SessionSign();
        $sessionSign->user_id = $user_id;
        $sessionSign->session_id = $session_id;
        $sessionSign->save();

        return redirect('/sessions/'.$session_id);
    }
}
