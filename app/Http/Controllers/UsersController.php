<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin', ['users' => User::all() ]);
    }

    /**
     * Store a newly created resource in storage.
     */
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
 
         return redirect('/admin')->with('success', 'Utilisateur ajouté avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect('/admin')->with('success', 'Utilisateur supprimé avec succès.');
    }
}
