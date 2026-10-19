<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Affiche la page de connexion & inscription.
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('page_client');
        }

        return view('login_client');
    }

    /**
     * Gère la tentative de connexion de l'utilisateur.
     */
    public function login(Request $request)
    {
        $messages = [
            'login.required' => 'L\'identifiant (Email ou Téléphone) est obligatoire.',
            'password.required' => 'Le mot de passe est obligatoire.',
        ];

        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ], $messages);

        $loginValue = trim($request->input('login'));
        $password = $request->input('password');
        $remember = $request->filled('remember');

        // Détection automatique: s'agit-il d'un email ou d'un numéro de téléphone ?
        $fieldType = filter_var($loginValue, FILTER_VALIDATE_EMAIL) ? 'email' : 'telephone';

        $credentials = [
            $fieldType => $loginValue,
            'password' => $password,
        ];

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            // Récupération de l'ID du client connecté depuis la base de données
            $clientId = Auth::id();
            $client = \App\Models\User::find($clientId);

            return redirect()->route('page_client')
                ->with('success', 'Ravi de vous revoir, ' . ($client->prenom ?? 'Cher client') . ' ! Connexion réussie.');
        }

        // Si la première tentative par téléphone échoue, on tente aussi sans espaces éventuels
        if ($fieldType === 'telephone') {
            $cleanPhone = str_replace([' ', '-', '.'], '', $loginValue);
            if ($cleanPhone !== $loginValue && Auth::attempt(['telephone' => $cleanPhone, 'password' => $password], $remember)) {
                $request->session()->regenerate();
                $clientId = Auth::id();
                $client = \App\Models\User::find($clientId);

                return redirect()->route('page_client')
                    ->with('success', 'Ravi de vous revoir, ' . ($client->prenom ?? 'Cher client') . ' ! Connexion réussie.');
            }
        }

        return redirect()->route('login')
            ->withInput($request->only('login', 'remember'))
            ->with('error', 'Identifiants incorrects. Veuillez vérifier votre adresse email / téléphone ou mot de passe.')
            ->with('active_tab', 'login');
    }

    /**
     * Déconnecte l'utilisateur.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')
            ->with('info', 'Vous avez été déconnecté avec succès. À bientôt !');
    }
}
