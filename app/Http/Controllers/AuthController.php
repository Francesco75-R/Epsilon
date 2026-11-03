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

    /**
     * Met à jour les informations du profil utilisateur connecté (Nom, Prénom, Téléphone, Adresse, Photo).
     * Stocke la photo dans public/photo en remplaçant l'ancienne image.
     */
    public function updateProfile(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Veuillez vous connecter pour modifier votre profil.');
        }

        $messages = [
            'nom.required' => 'Le nom est obligatoire.',
            'nom.max' => 'Le nom ne peut pas dépasser 60 caractères.',
            'prenom.required' => 'Le prénom est obligatoire.',
            'prenom.max' => 'Le prénom ne peut pas dépasser 60 caractères.',
            'telephone.required' => 'Le numéro de téléphone est obligatoire.',
            'telephone.max' => 'Le téléphone ne peut pas dépasser 35 caractères.',
            'adresse.required' => 'L\'adresse de résidence est obligatoire.',
            'adresse.max' => 'L\'adresse ne peut pas dépasser 255 caractères.',
            'genre.required' => 'Veuillez sélectionner votre genre.',
            'genre.in' => 'Veuillez choisir un genre valide (Masculin ou Féminin).',
            'photo.image' => 'Le fichier doit être une image valide.',
            'photo.mimes' => 'Formats acceptés pour la photo : JPG, JPEG, PNG, WEBP.',
            'photo.max' => 'La photo ne doit pas dépasser 5 Mo.',
        ];

        $request->validate([
            'nom' => 'required|string|max:60',
            'prenom' => 'required|string|max:60',
            'telephone' => 'required|string|max:35',
            'adresse' => 'required|string|max:255',
            'genre' => 'required|string|in:Masculin,Féminin,Homme,Femme',
            'photo' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:5120',
        ], $messages);

        $user->nom = trim($request->nom);
        $user->prenom = trim($request->prenom);
        $user->telephone = trim($request->telephone);
        $user->adresse = trim($request->adresse);
        $user->genre = trim($request->genre);

        // Upload et remplacement de la photo de profil dans public/photo
        if ($request->hasFile('photo')) {
            $photoDir = public_path('photo');
            if (!file_exists($photoDir)) {
                mkdir($photoDir, 0755, true);
            }

            // Supprimer l'ancienne photo physique si existante et non par défaut
            if ($user->photo && file_exists(public_path($user->photo)) && !str_contains($user->photo, 'default.png')) {
                @unlink(public_path($user->photo));
            }

            $filename = time() . '_photo_' . uniqid() . '.' . $request->file('photo')->getClientOriginalExtension();
            $request->file('photo')->move($photoDir, $filename);
            $user->photo = 'photo/' . $filename;
        }

        $user->save();

        return redirect()->route('dashboard', ['tab' => 'profil'])
            ->with('success', 'Félicitations ! Vos informations de profil ont été mises à jour avec succès.');
    }

    /**
     * Affiche l'écran de saisie du code OTP à 6 chiffres pour la vérification du compte.
     */
    public function showVerifyEmailOtp()
    {
        $userId = session('verify_user_id');
        $email = session('verify_email');

        if (!$userId || !$email) {
            return redirect()->route('login')
                ->with('info', 'Veuillez vous connecter à votre compte.');
        }

        return view('auth.verify-email-otp', compact('email'));
    }

    /**
     * Valide le code OTP à 6 chiffres et met à jour email_verified_at.
     */
    public function verifyEmailOtp(Request $request)
    {
        $userId = session('verify_user_id');
        $email = session('verify_email');

        if (!$userId) {
            return redirect()->route('login')->with('error', 'Session expirée. Veuillez vous reconnecter.');
        }

        // Concaténation des 6 chiffres si envoyés individuellement (digit1..digit6) ou champ unique (code)
        $code = $request->input('code');
        if (!$code && $request->has('digit1')) {
            $code = $request->input('digit1') .
                    $request->input('digit2') .
                    $request->input('digit3') .
                    $request->input('digit4') .
                    $request->input('digit5') .
                    $request->input('digit6');
        }

        $code = trim($code);

        if (strlen($code) !== 6 || !ctype_digit($code)) {
            return back()->with('error', 'Veuillez renseigner un code valide à 6 chiffres.')->withInput();
        }

        $expectedCode = session('register_otp');
        $expiresAt = session('register_otp_expires_at');

        if ($expiresAt && now()->greaterThan($expiresAt)) {
            return back()->with('error', 'Ce code de vérification a expiré. Veuillez cliquer sur "Renvoyer un code".');
        }

        if ($code !== $expectedCode) {
            return back()->with('error', 'Le code de vérification saisi est incorrect. Veuillez vérifier votre boîte mail et réessayer.')->withInput();
        }

        // Validation réussie : mise à jour de la colonne native email_verified_at
        $user = \App\Models\User::findOrFail($userId);
        $user->email_verified_at = now();
        $user->save();

        // Connexion immédiate du client
        Auth::login($user);

        // Nettoyage de la session
        session()->forget(['verify_user_id', 'verify_email', 'register_otp', 'register_otp_expires_at']);

        return redirect()->route('dashboard')
            ->with('success', 'Félicitations ' . $user->prenom . ' ! Votre adresse email a été validée avec succès. Bienvenue sur Epsilon !');
    }

    /**
     * Renvoi d'un nouveau code OTP d'inscription.
     */
    public function resendEmailOtp()
    {
        $userId = session('verify_user_id');
        if (!$userId) {
            return redirect()->route('login');
        }

        $user = \App\Models\User::findOrFail($userId);
        $otp = (string) random_int(100000, 999999);

        session([
            'register_otp' => $otp,
            'register_otp_expires_at' => now()->addMinutes(15),
        ]);

        try {
            $html = '
            <div style="font-family: \'Plus Jakarta Sans\', Arial, sans-serif; max-width: 560px; margin: 0 auto; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; overflow: hidden;">
                <div style="background: #0A1128; padding: 24px; text-align: center;">
                    <h1 style="color: #ffffff; margin: 0; font-size: 24px; font-weight: 800;">Epsilon Marketplace</h1>
                    <p style="color: #10B981; margin: 4px 0 0 0; font-size: 12px; font-weight: 600; text-transform: uppercase;">Nouveau code de vérification</p>
                </div>
                <div style="padding: 32px 28px;">
                    <p style="font-size: 15px; color: #1e293b; margin-top: 0;">Bonjour <strong>' . htmlspecialchars($user->prenom) . '</strong>,</p>
                    <p style="font-size: 14px; color: #475569; line-height: 1.6;">Voici votre nouveau code à 6 chiffres pour valider votre inscription :</p>
                    <div style="text-align: center; margin: 28px 0;">
                        <span style="display: inline-block; font-size: 32px; font-weight: 800; letter-spacing: 8px; color: #006c4a; background: #ecfdf5; border: 2px dashed #10b981; padding: 14px 28px; border-radius: 12px;">' . $otp . '</span>
                    </div>
                    <p style="font-size: 13px; color: #64748b;">Valable pendant 15 minutes.</p>
                </div>
            </div>';

            \Illuminate\Support\Facades\Mail::html($html, function ($message) use ($user, $otp) {
                $message->to($user->email, $user->prenom . ' ' . $user->nom)
                        ->subject('Nouveau code de vérification Epsilon : ' . $otp);
            });
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Erreur renvoi SMTP Inscription : ' . $e->getMessage());
        }

        return back()->with('status', 'Un nouveau code à 6 chiffres vous a été envoyé par e-mail.');
    }
}


