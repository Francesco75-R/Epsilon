<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class insert_users extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'adresse' => 'required|string',
            'genre' => 'required|string',
            'profil' => 'required|image|mimes:jpeg,jpg,png,webp|max:3000',
            'carte' => 'required|image|mimes:jpeg,jpg,png,webp|max:3000',
            'password' => 'required|string|min:8',
        ]);
        $profilpath = null;
        if ($request->hasFile('profil')) {
            $profilfile = $request->file('profil');
            $profilname = time() . '_photo_' . uniqid() . '.' . $profilfile->getClientOriginalExtension();
            $profilfile->move(public_path('photo'), $profilname);
            $profilpath = 'photo/' . $profilname;
        }
        $cartepath =  null;
        if ($request->hasFile('carte')) {
            $cartefile = $request->file('carte');
            $cartename = time() . '_carte_' . uniqid() . '.' . $cartefile->getClientOriginalExtension();
            $cartefile->move(public_path('photo'), $cartename);
            $cartepath = 'photo/' . $cartename;
        }

        users::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'phone' => $request->phone,
            'adresse' => $request->adresse,
            'genre' => $request->genre,
            'profil' => $profilpath,
            'carte' => $cartepath,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('home')->with('success', 'Utilisateur créé avec succès');
    }
}
