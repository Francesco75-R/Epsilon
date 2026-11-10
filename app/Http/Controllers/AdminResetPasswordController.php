<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminResetPasswordController extends Controller
{
    /**
     * Étape 3 : Affiche le formulaire avec Nouveau mot de passe administrateur et Confirmation.
     */
    public function showResetPasswordForm()
    {
        $email = session('admin_reset_password_email');
        $verified = session('admin_password_reset_verified');

        if (!$email || !$verified) {
            return redirect()->route('admin.password.request')
                ->with('error', 'Veuillez valider le code à 6 chiffres avant de définir votre nouveau mot de passe administrateur.');
        }

        return view('admin.auth.reset-password', compact('email'));
    }

    /**
     * Étape 3 (Soumission) : Valide et met à jour le mot de passe dans la table `admin`.
     */
    public function submitNewPassword(Request $request)
    {
        $email = session('admin_reset_password_email');
        $verified = session('admin_password_reset_verified');

        if (!$email || !$verified) {
            return redirect()->route('admin.password.request')
                ->with('error', 'Session expirée. Veuillez recommencer la procédure.');
        }

        $messages = [
            'password.required'  => 'Le nouveau mot de passe est obligatoire.',
            'password.min'       => 'Le mot de passe doit comporter au moins 8 caractères.',
            'password.confirmed' => 'La confirmation ne correspond pas au mot de passe saisi.',
        ];

        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ], $messages);

        $admin = Admin::where('email', $email)->first();
        if (!$admin) {
            return redirect()->route('admin.password.request')
                ->with('error', 'Administrateur introuvable. Veuillez recommencer.');
        }

        $admin->password = Hash::make($request->password);
        $admin->save();

        // Nettoyage du token et de la session admin
        DB::table('password_reset_tokens')->where('email', $email)->delete();
        session()->forget([
            'admin_reset_password_email',
            'admin_reset_otp_plain',
            'admin_reset_otp_expires_at',
            'admin_password_reset_verified',
        ]);

        return redirect()->route('admin.login')
            ->with('success', 'Votre mot de passe administrateur a été modifié avec succès ! Vous pouvez maintenant vous connecter.')
            ->with('active_tab', 'login');
    }
}

