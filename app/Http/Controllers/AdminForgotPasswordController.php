<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class AdminForgotPasswordController extends Controller
{
    /**
     * Étape 1 : Formulaire de saisie de l'e-mail administrateur.
     */
    public function showLinkRequestForm()
    {
        return view('admin.auth.forgot-password');
    }

    /**
     * Étape 1 (Soumission) : Génère et envoie le code OTP à 6 chiffres par e-mail à l'administrateur.
     */
    public function sendResetOtp(Request $request)
    {
        $messages = [
            'email.required' => 'L\'adresse e-mail administrateur est obligatoire.',
            'email.email'    => 'Veuillez saisir une adresse e-mail valide.',
            'email.exists'   => 'Aucun compte administrateur n\'est associé à cette adresse e-mail.',
        ];

        $request->validate([
            'email' => 'required|email|exists:admin,email',
        ], $messages);

        $email = strtolower(trim($request->email));
        $admin = Admin::where('email', $email)->firstOrFail();

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

        // Mémorisation en session pour l'espace administrateur
        session([
            'admin_reset_password_email' => $email,
            'admin_reset_otp_plain'      => $otp,
            'admin_reset_otp_expires_at' => now()->addMinutes(15),
        ]);

        // Envoi de l'e-mail de réinitialisation sécurisé
        try {
            $html = '
            <div style="font-family: \'Plus Jakarta Sans\', Arial, sans-serif; max-width: 560px; margin: 0 auto; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 16px rgba(0,0,0,0.05);">
                <div style="background: #0A1128; padding: 24px; text-align: center;">
                    <h1 style="color: #ffffff; margin: 0; font-size: 24px; font-weight: 800;">Epsilon Administration</h1>
                    <p style="color: #10B981; margin: 4px 0 0 0; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px;">Sécurité Espace Administrateur</p>
                </div>
                <div style="padding: 32px 28px;">
                    <p style="font-size: 15px; color: #1e293b; margin-top: 0;">Bonjour Administrateur <strong>' . htmlspecialchars($admin->prenom) . ' ' . htmlspecialchars($admin->nom) . '</strong>,</p>
                    <p style="font-size: 14px; color: #475569; line-height: 1.6;">Vous avez demandé la réinitialisation de votre mot de passe pour accéder au panneau d\'administration Epsilon. Voici votre code de vérification à 6 chiffres :</p>
                    <div style="text-align: center; margin: 28px 0;">
                        <span style="display: inline-block; font-size: 32px; font-weight: 800; letter-spacing: 8px; color: #006c4a; background: #ecfdf5; border: 2px dashed #10b981; padding: 14px 28px; border-radius: 12px;">' . $otp . '</span>
                    </div>
                    <p style="font-size: 13px; color: #64748b; line-height: 1.5;">Ce code expire dans <strong>15 minutes</strong>. Si vous n\'êtes pas à l\'origine de cette demande, veuillez vérifier la sécurité de votre compte administrateur.</p>
                </div>
                <div style="background: #f8fafc; padding: 16px; text-align: center; border-top: 1px solid #e2e8f0; font-size: 12px; color: #94a3b8;">
                    © ' . date('Y') . ' Epsilon Marketplace Togo - Espace Administration.
                </div>
            </div>';

            Mail::html($html, function ($message) use ($email, $admin, $otp) {
                $message->to($email, $admin->prenom . ' ' . $admin->nom)
                        ->subject('Code de réinitialisation Administrateur Epsilon : ' . $otp);
            });
        } catch (\Throwable $e) {
            Log::error('Erreur SMTP lors de la réinitialisation Admin : ' . $e->getMessage());
        }

        return redirect()->route('admin.password.otp.form')
            ->with('status', 'Un code de confirmation à 6 chiffres a été envoyé à l\'adresse ' . $email . '.');
    }

    /**
     * Étape 2 : Écran de saisie du code OTP administrateur.
     */
    public function showOtpForm()
    {
        $email = session('admin_reset_password_email');
        if (!$email) {
            return redirect()->route('admin.password.request')
                ->with('error', 'Veuillez d\'abord saisir votre adresse e-mail administrateur.');
        }

        return view('admin.auth.verify-password-otp', compact('email'));
    }

    /**
     * Étape 2 (Validation) : Vérifie le code OTP à 6 chiffres saisi.
     */
    public function verifyOtp(Request $request)
    {
        $email = session('admin_reset_password_email');
        if (!$email) {
            return redirect()->route('admin.password.request')
                ->with('error', 'Session expirée. Veuillez recommencer.');
        }

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

        $record = DB::table('password_reset_tokens')->where('email', $email)->first();
        $isPlainMatch = (session('admin_reset_otp_plain') === $code);
        $isHashMatch = ($record && Hash::check($code, $record->token));

        $expiresAt = session('admin_reset_otp_expires_at');
        $isExpired = $expiresAt && now()->greaterThan($expiresAt);

        if (($isPlainMatch || $isHashMatch) && !$isExpired) {
            session(['admin_password_reset_verified' => true]);

            return redirect()->route('admin.password.reset.form')
                ->with('status', 'Code validé avec succès. Vous pouvez maintenant définir votre nouveau mot de passe administrateur.');
        }

        return back()->with('error', 'Code de vérification incorrect ou expiré. Veuillez vérifier le code reçu ou en demander un nouveau.')->withInput();
    }

    /**
     * Renvoi d'un nouveau code OTP administrateur.
     */
    public function resendResetOtp(Request $request)
    {
        $email = session('admin_reset_password_email');
        if (!$email) {
            return redirect()->route('admin.password.request');
        }

        $fakeRequest = new Request(['email' => $email]);
        return $this->sendResetOtp($fakeRequest);
    }
}

