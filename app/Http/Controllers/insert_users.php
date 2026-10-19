<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Exception; // <-- Ne pas oublier d'importer Exception

class insert_users extends Controller
{
    public function store(Request $request)
    {
        // 1. Validation complète avec messages d'erreur détaillés en français
        $messages = [
            'nom.required' => 'Le nom est obligatoire.',
            'nom.string' => 'Le nom doit être une chaîne de caractères valide.',
            'nom.max' => 'Le nom ne peut pas dépasser 60 caractères.',

            'prenom.required' => 'Le prénom est obligatoire.',
            'prenom.string' => 'Le prénom doit être une chaîne de caractères valide.',
            'prenom.max' => 'Le prénom ne peut pas dépasser 60 caractères.',

            'email.required' => 'L\'adresse email est obligatoire.',
            'email.email' => 'Veuillez saisir une adresse email valide.',
            'email.unique' => 'Cet email existe déjà dans notre système. Veuillez vous connecter ou utiliser un autre email.',
            'email.max' => 'L\'email ne peut pas dépasser 90 caractères.',

            'phone.required' => 'Le numéro de téléphone est obligatoire.',
            'phone.string' => 'Le numéro de téléphone n\'est pas valide.',
            'phone.max' => 'Le numéro de téléphone ne peut pas dépasser 35 caractères.',

            'adresse.required' => 'L\'adresse est obligatoire.',
            'adresse.string' => 'L\'adresse doit être valide.',
            'adresse.max' => 'L\'adresse ne peut pas dépasser 255 caractères.',

            'genre.required' => 'Veuillez sélectionner votre genre (Homme ou Femme).',
            'genre.in' => 'Le genre sélectionné doit être Homme ou Femme.',

            'profil.required' => 'La photo de profil est requise pour sécuriser votre compte.',
            'profil.image' => 'Le fichier de profil doit impérativement être une image.',
            'profil.mimes' => 'La photo de profil doit être au format JPG, JPEG, PNG ou WEBP.',
            'profil.max' => 'La photo de profil ne doit pas dépasser 3 Mo.',

            'carte.required' => 'La pièce d\'identité est requise pour certifier votre compte vendeur.',
            'carte.image' => 'La pièce d\'identité doit impérativement être une image.',
            'carte.mimes' => 'La pièce d\'identité doit être au format JPG, JPEG, PNG ou WEBP.',
            'carte.max' => 'La pièce d\'identité ne doit pas dépasser 3 Mo.',

            'password.required' => 'Le mot de passe est obligatoire.',
            'password.string' => 'Le mot de passe doit être valide.',
            'password.min' => 'Le mot de passe doit comporter au moins 8 caractères.',
            'password.confirmed' => 'Les deux mots de passe ne sont pas identiques.',
        ];

        $request->validate([
            'nom' => 'required|string|max:60',
            'prenom' => 'required|string|max:60',
            'email' => 'required|email|max:90|unique:users,email',
            'phone' => 'required|string|max:35',
            'adresse' => 'required|string|max:255',
            'genre' => 'required|string|in:Homme,Femme',
            'profil' => 'required|image|mimes:jpeg,jpg,png,webp|max:7168',
            'carte' => 'required|image|mimes:jpeg,jpg,png,webp|max:7168',
            'password' => 'required|string|min:8|confirmed',
        ], $messages);

        // 2. Traitement des fichiers et insertion sécurisée
        try {
            // Création du dossier d'upload s'il n'existe pas
            $uploadDirectory = public_path('photo');
            if (!file_exists($uploadDirectory)) {
                mkdir($uploadDirectory, 0755, true);
            }

            $profilpath = null;
            if ($request->hasFile('profil')) {
                $profilfile = $request->file('profil');
                $profilname = time() . '_photo_' . uniqid() . '.' . $profilfile->getClientOriginalExtension();
                $profilfile->move($uploadDirectory, $profilname);
                $profilpath = 'photo/' . $profilname;
            }

            $cartepath = null;
            if ($request->hasFile('carte')) {
                $cartefile = $request->file('carte');
                $cartename = time() . '_carte_' . uniqid() . '.' . $cartefile->getClientOriginalExtension();
                $cartefile->move($uploadDirectory, $cartename);
                $cartepath = 'photo/' . $cartename;
            }

            User::create([
                'nom' => trim($request->nom),
                'prenom' => trim($request->prenom),
                'email' => strtolower(trim($request->email)),
                'telephone' => trim($request->phone),
                'adresse' => trim($request->adresse),
                'genre' => $request->genre,
                'photo' => $profilpath,
                'carte' => $cartepath,
                'password' => Hash::make($request->password),
            ]);

            // Redirection vers la page de connexion avec le message de succès et focus sur tab connexion
            return redirect()->route('login')
                ->with('success', 'Votre compte Epsilon a été créé avec succès ! Vous pouvez maintenant vous connecter.')
                ->with('active_tab', 'login');
        } catch (Exception $e) {
            // En cas d'erreur inattendue (base de données, disque, etc.), on conserve les saisies
            return redirect()->route('login')
                ->withInput()
                ->with('error', 'Une erreur est survenue lors de l\'inscription : ' . $e->getMessage())
                ->with('active_tab', 'signup');
        }
    }
}
