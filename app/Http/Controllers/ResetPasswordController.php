<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class ResetPasswordController extends Controller
{
    /**
     * Étape 3 : Affiche le formulaire avec Nouveau mot de passe et Confirmation du mot de passe.
     */
    public function showResetPasswordForm()
    {
        $email = session('reset_password_email');
        $verified = session('password_reset_verified');

        if (!$email || !$verified) {
            return redirect()->route('password.request')
                ->with('error', 'Veuillez valider le code à 6 chiffres avant de définir votre nouveau mot de passe.');
        }

        return view('auth.reset-password', compact('email'));
    }

    /**
     * Étape 3 (Soumission) : Valide et met à jour le mot de passe dans la table users.
     */
    public function submitNewPassword(Request $request)
    {
        $email = session('reset_password_email');
        $verified = session('password_reset_verified');

        if (!$email || !$verified) {
            return redirect()->route('password.request')
                ->with('error', 'Session expirée. Veuillez recommencer la procédure.');
        }

        $messages = [
            'password.required' => 'Le nouveau mot de passe est obligatoire.',
            'password.min' => 'Le mot de passe doit comporter au moins 8 caractères.',
            'password.confirmed' => 'La confirmation ne correspond pas au mot de passe saisi.',
        ];

        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ], $messages);

        // Récupération de l'utilisateur
        $user = User::where('email', $email)->first();
        if (!$user) {
            return redirect()->route('password.request')
                ->with('error', 'Utilisateur introuvable. Veuillez recommencer.');
        }

        // Hachage et mise à jour du mot de passe
        $user->password = Hash::make($request->password);
        $user->save();

        // Nettoyage de la table password_reset_tokens et de la session
        DB::table('password_reset_tokens')->where('email', $email)->delete();
        session()->forget([
            'reset_password_email',
            'reset_otp_plain',
            'reset_otp_expires_at',
            'password_reset_verified'
        ]);

        return redirect()->route('login')
            ->with('success', 'Votre mot de passe a été modifié avec succès ! Vous pouvez maintenant vous connecter.')
            ->with('active_tab', 'login');
    }
}
