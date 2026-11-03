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
            'password' => 'required|string|min:8|confirmed',
        ], $messages);

        // 2. Traitement des fichiers et insertion sécurisée
        try {

            $user = User::create([
                'nom' => trim($request->nom),
                'prenom' => trim($request->prenom),
                'email' => strtolower(trim($request->email)),
                'telephone' => trim($request->phone),
                'adresse' => null,
                'genre' => null,
                'photo' => null,
                'carte' => null,
                'password' => Hash::make($request->password),
                'email_verified_at' => null,
            ]);

            // Génération d'un code OTP à 6 chiffres pour la vérification du compte
            $otp = (string) random_int(100000, 999999);

            // Mémorisation en session
            session([
                'verify_user_id' => $user->id,
                'verify_email' => $user->email,
                'register_otp' => $otp,
                'register_otp_expires_at' => now()->addMinutes(15),
            ]);

            // Envoi de l'e-mail via SMTP Outlook
            try {
                $html = '
                <div style="font-family: \'Plus Jakarta Sans\', Arial, sans-serif; max-width: 560px; margin: 0 auto; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 16px rgba(0,0,0,0.05);">
                    <div style="background: #0A1128; padding: 24px; text-align: center;">
                        <h1 style="color: #ffffff; margin: 0; font-size: 24px; font-weight: 800;">Epsilon Marketplace</h1>
                        <p style="color: #10B981; margin: 4px 0 0 0; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px;">Bienvenue parmi nous</p>
                    </div>
                    <div style="padding: 32px 28px;">
                        <p style="font-size: 15px; color: #1e293b; margin-top: 0;">Félicitations <strong>' . htmlspecialchars($user->prenom) . ' ' . htmlspecialchars($user->nom) . '</strong>,</p>
                        <p style="font-size: 14px; color: #475569; line-height: 1.6;">Merci d\'avoir rejoint Epsilon Marketplace Togo. Pour finaliser votre inscription et activer votre compte vendeur/acheteur, veuillez saisir ce code de vérification à 6 chiffres :</p>
                        <div style="text-align: center; margin: 28px 0;">
                            <span style="display: inline-block; font-size: 32px; font-weight: 800; letter-spacing: 8px; color: #006c4a; background: #ecfdf5; border: 2px dashed #10b981; padding: 14px 28px; border-radius: 12px;">' . $otp . '</span>
                        </div>
                        <p style="font-size: 13px; color: #64748b; line-height: 1.5;">Ce code expire dans <strong>15 minutes</strong>. Ne le partagez avec personne.</p>
                    </div>
                    <div style="background: #f8fafc; padding: 16px; text-align: center; border-top: 1px solid #e2e8f0; font-size: 12px; color: #94a3b8;">
                        © ' . date('Y') . ' Epsilon Marketplace Togo. Tous droits réservés.
                    </div>
                </div>';

                \Illuminate\Support\Facades\Mail::html($html, function ($message) use ($user, $otp) {
                    $message->to($user->email, $user->prenom . ' ' . $user->nom)
                        ->subject('Code de vérification de votre compte Epsilon : ' . $otp);
                });
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::error('Erreur SMTP Inscription : ' . $e->getMessage());
            }

            // Redirection vers l'écran de validation du code OTP
            return redirect()->route('verification.otp.form')
                ->with('status', 'Un code de confirmation à 6 chiffres a été envoyé à ' . $user->email . '.');
        } catch (Exception $e) {
            // En cas d'erreur inattendue (base de données, disque, etc.), on conserve les saisies
            return redirect()->route('login')
                ->withInput()
                ->with('error', 'Une erreur est survenue lors de l\'inscription : ' . $e->getMessage())
                ->with('active_tab', 'signup');
        }
    }
}
