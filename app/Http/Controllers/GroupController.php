<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;

class GroupController extends Controller
{
    public function CreateGroups(request $request){
        // Valider les données du formulaire si nécessaire
        // $data = $request->validate([
        //     'name' => 'required|string|max:255',
        //     // Autres règles de validation
        // ]);
        
        // Créer un nouveau groupe
        $group = new Group();
        $int = $request->input('name');
        $group->numero = $int;
        // Définir d'autres attributs si nécessaire

        $group->save();
        
        // Rediriger ou effectuer d'autres actions après la création du groupe
    }
    
}
