<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ForgotPasswordController extends Controller
{
    /**
     * Étape 1 : Formulaire de saisie de l'e-mail.
     */
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Étape 1 (Soumission) : Génère et envoie le code OTP à 6 chiffres par e-mail.
     */
    public function sendResetOtp(Request $request)
    {
        $messages = [
            'email.required' => 'L\'adresse e-mail est obligatoire.',
            'email.email' => 'Veuillez saisir une adresse e-mail valide.',
            'email.exists' => 'Aucun compte n\'est associé à cette adresse e-mail.',
        ];

        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], $messages);

        $email = strtolower(trim($request->email));
        $user = User::where('email', $email)->firstOrFail();

        // Génération d'un code OTP sécurisé à 6 chiffres
        $otp = (string) random_int(100000, 999999);

        // Sauvegarde dans la table système password_reset_tokens
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $email],
            [
                'token' => Hash::make($otp),
                'created_at' => now(),
            ]
        );

        // Mémorisation en session
        session([
            'reset_password_email' => $email,
            'reset_otp_plain' => $otp,
            'reset_otp_expires_at' => now()->addMinutes(15),
        ]);

        // Envoi de l'e-mail via le SMTP Outlook
        try {
            $html = '
            <div style="font-family: \'Plus Jakarta Sans\', Arial, sans-serif; max-width: 560px; margin: 0 auto; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 16px rgba(0,0,0,0.05);">
                <div style="background: #0A1128; padding: 24px; text-align: center;">
                    <h1 style="color: #ffffff; margin: 0; font-size: 24px; font-weight: 800;">Epsilon Marketplace</h1>
                    <p style="color: #10B981; margin: 4px 0 0 0; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px;">Sécurité du compte</p>
                </div>
                <div style="padding: 32px 28px;">
                    <p style="font-size: 15px; color: #1e293b; margin-top: 0;">Bonjour <strong>' . htmlspecialchars($user->prenom) . '</strong>,</p>
                    <p style="font-size: 14px; color: #475569; line-height: 1.6;">Vous avez demandé la réinitialisation de votre mot de passe sur la plateforme Epsilon. Voici votre code de vérification à 6 chiffres :</p>
                    <div style="text-align: center; margin: 28px 0;">
                        <span style="display: inline-block; font-size: 32px; font-weight: 800; letter-spacing: 8px; color: #006c4a; background: #ecfdf5; border: 2px dashed #10b981; padding: 14px 28px; border-radius: 12px;">' . $otp . '</span>
                    </div>
                    <p style="font-size: 13px; color: #64748b; line-height: 1.5;">Ce code est valable pendant <strong>15 minutes</strong>. Si vous n\'êtes pas à l\'origine de cette demande, vous pouvez ignorer cet e-mail en toute sécurité.</p>
                </div>
                <div style="background: #f8fafc; padding: 16px; text-align: center; border-top: 1px solid #e2e8f0; font-size: 12px; color: #94a3b8;">
                    © ' . date('Y') . ' Epsilon Marketplace Togo. Tous droits réservés.
                </div>
            </div>';

            Mail::html($html, function ($message) use ($email, $user, $otp) {
                $message->to($email, $user->prenom . ' ' . $user->nom)
                        ->subject('Code de réinitialisation Epsilon : ' . $otp);
            });
        } catch (\Throwable $e) {
            Log::error('Erreur SMTP Outlook lors de la réinitialisation : ' . $e->getMessage());
        }

        return redirect()->route('password.otp.form')
            ->with('status', 'Un code de confirmation à 6 chiffres a été envoyé à l\'adresse ' . $email . '.');
    }

    /**
     * Étape 2 : Écran de saisie du code OTP à 6 chiffres.
     */
    public function showOtpForm()
    {
        $email = session('reset_password_email');
        if (!$email) {
            return redirect()->route('password.request')
                ->with('error', 'Veuillez d\'abord saisir votre adresse e-mail.');
        }

        return view('auth.verify-password-otp', compact('email'));
    }

    /**
     * Étape 2 (Validation) : Vérifie le code OTP à 6 chiffres saisi.
     */
    public function verifyOtp(Request $request)
    {
        $email = session('reset_password_email');
        if (!$email) {
            return redirect()->route('password.request')
                ->with('error', 'Session expirée. Veuillez recommencer.');
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
            return back()->with('error', 'Veuillez saisir un code valide à 6 chiffres.')->withInput();
        }

        // Vérification dans la table password_reset_tokens ou session
        $record = DB::table('password_reset_tokens')->where('email', $email)->first();
        $isPlainMatch = (session('reset_otp_plain') === $code);
        $isHashMatch = ($record && Hash::check($code, $record->token));

        // Vérification de la validité temporelle (15 minutes max)
        $expiresAt = session('reset_otp_expires_at');
        $isExpired = $expiresAt && now()->greaterThan($expiresAt);

        if (($isPlainMatch || $isHashMatch) && !$isExpired) {
            // Marquer l'OTP comme validé en session
            session(['password_reset_verified' => true]);

            return redirect()->route('password.reset.form')
                ->with('status', 'Code validé avec succès. Vous pouvez maintenant définir votre nouveau mot de passe.');
        }

        return back()->with('error', 'Code de vérification incorrect ou expiré. Veuillez vérifier le code reçu ou en demander un nouveau.')->withInput();
    }

    /**
     * Renvoi d'un nouveau code OTP.
     */
    public function resendResetOtp(Request $request)
    {
        $email = session('reset_password_email');
        if (!$email) {
            return redirect()->route('password.request');
        }

        $fakeRequest = new Request(['email' => $email]);
        return $this->sendResetOtp($fakeRequest);
    }
}
