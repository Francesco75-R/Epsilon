<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Exception;

class AdminAuthController extends Controller
{
    /**
     * Affiche l'écran de connexion et inscription de l'espace administration.
     */
    public function showLogin()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard')
                ->with('success', 'Session administrateur active.');
        }

        return view('login_admin');
    }

    /**
     * Dashboard / Accueil de l'espace Administrateur (Console de modération et vérification).
     */
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    /**
     * Traite la tentative de connexion d'un administrateur.
     */
    public function login(Request $request)
    {
        $messages = [
            'login.required'    => 'L\'adresse e-mail administrateur est obligatoire.',
            'password.required' => 'Le mot de passe administrateur est obligatoire.',
        ];

        $request->validate([
            'login'    => 'required|string',
            'password' => 'required|string',
        ], $messages);

        $loginValue = strtolower(trim($request->input('login')));
        $password = $request->input('password');
        $remember = $request->filled('remember');

        $credentials = [
            'email'    => $loginValue,
            'password' => $password,
        ];

        if (Auth::guard('admin')->attempt($credentials, $remember)) {
            $request->session()->regenerate();

            /** @var Admin $admin */
            $admin = Auth::guard('admin')->user();

            return redirect()->route('admin.dashboard')
                ->with('success', 'Ravi de vous revoir, Administrateur ' . ($admin->prenom ?? '') . ' ! Connexion sécurisée réussie.');
        }

        return redirect()->route('admin.login')
            ->withInput($request->only('login', 'remember'))
            ->with('error', 'Identifiants administrateur incorrects. Accès strictement réservé.')
            ->with('active_tab', 'login');
    }

    /**
     * Traite l'enregistrement d'un nouvel administrateur dans la table `admin`.
     * Aucun e-mail n'est envoyé lors de l'enregistrement.
     * Dès l'inscription terminée, l'utilisateur est redirigé vers l'onglet Connexion de `login_admin`.
     */
    public function register(Request $request)
    {
        $messages = [
            'nom.required'       => 'Le nom est obligatoire.',
            'nom.string'         => 'Le nom doit être une chaîne de caractères valide.',
            'nom.max'            => 'Le nom ne peut pas dépasser 50 caractères.',

            'prenom.required'    => 'Le prénom est obligatoire.',
            'prenom.string'      => 'Le prénom doit être une chaîne de caractères valide.',
            'prenom.max'         => 'Le prénom ne peut pas dépasser 50 caractères.',

            'email.required'     => 'L\'adresse email est obligatoire.',
            'email.email'        => 'Veuillez saisir une adresse email valide.',
            'email.unique'       => 'Cet email administrateur est déjà enregistré.',
            'email.max'          => 'L\'email ne peut pas dépasser 60 caractères.',

            'password.required'  => 'Le mot de passe est obligatoire.',
            'password.string'    => 'Le mot de passe doit être valide.',
            'password.min'       => 'Le mot de passe doit comporter au moins 8 caractères.',
            'password.confirmed' => 'Les deux mots de passe ne sont pas identiques.',
        ];

        $request->validate([
            'nom'      => 'required|string|max:50',
            'prenom'   => 'required|string|max:50',
            'email'    => 'required|email|max:60|unique:admin,email',
            'password' => 'required|string|min:8|confirmed',
        ], $messages);

        try {
            $admin = Admin::create([
                'nom'      => trim($request->nom),
                'prenom'   => trim($request->prenom),
                'email'    => strtolower(trim($request->email)),
                'password' => Hash::make($request->password),
            ]);

            // Redirection vers le formulaire de connexion Admin sur login_admin avec l'onglet login activé
            return redirect()->route('admin.login')
                ->with('success', 'Félicitations ' . $admin->prenom . ' ! Votre compte administrateur a été créé avec succès. Veuillez vous connecter ci-dessous.')
                ->with('active_tab', 'login');
        } catch (Exception $e) {
            Log::error('Erreur inscription administrateur : ' . $e->getMessage(), ['exception' => $e]);
            return redirect()->route('admin.login')
                ->withInput()
                ->with('error', 'Une erreur inattendue est survenue lors de la création du compte administrateur. Veuillez réessayer.')
                ->with('active_tab', 'signup');
        }
    }

    /**
     * Déconnecte l'administrateur et le renvoie sur la page de connexion admin.
     */
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')
            ->with('info', 'Vous avez été déconnecté de l\'espace administration.');
    }
}
