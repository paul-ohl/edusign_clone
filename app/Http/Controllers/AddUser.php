<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AddUser extends Controller
{
    public function store(Request $request)
    {
        // Accédez au nom de l'utilisateur
        $name = $request->input('name');

        // Accédez au statut de l'utilisateur
        $status = $request->input('status');

        // Enregistrez l'utilisateur dans la base de données ou effectuez d'autres actions ici

        $user = new User();
        $user->name = $name;
        $user->status = $status;

        $user->save();

        return redirect()->back()->with('success', 'Utilisateur ajouté avec succès.');
    }
}