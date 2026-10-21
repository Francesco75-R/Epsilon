<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\insert_users;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AnnonceController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;

/*
|--------------------------------------------------------------------------
| Web Routes - Epsilon Marketplace
|--------------------------------------------------------------------------
| 1. Page d'accueil publique : Affiche toutes les annonces publiées
| 2. Espace Membre (Dashboard) : Annonces privées, statistiques & publication
| 3. Page client public : Profil et annonces d'un vendeur spécifique
| 4. Authentification & Réinitialisation de mot de passe
*/

// 1. Page d'accueil publique (Annonces globales de tous les utilisateurs)
Route::get('/', [AnnonceController::class, 'index'])->name('home');

// 2. Authentification (Connexion & Déconnexion)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 3. Inscription Utilisateur & Vérification par Code OTP à 6 chiffres
Route::post('/insert_client', [insert_users::class, 'store'])->name('insert_client.store');
Route::post('/register-client', [insert_users::class, 'store'])->name('register.store');
Route::get('/verify-email-otp', [AuthController::class, 'showVerifyEmailOtp'])->name('verification.otp.form');
Route::post('/verify-email-otp', [AuthController::class, 'verifyEmailOtp'])->name('verification.otp.submit');
Route::post('/verify-email-otp/resend', [AuthController::class, 'resendEmailOtp'])->name('verification.otp.resend');

// 4. Réinitialisation du mot de passe avec Code OTP à 6 chiffres (3 Étapes)
// Étape 1 : Saisie de l'e-mail et envoi du code OTP
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetOtp'])->name('password.email');

// Étape 2 : Saisie et validation du code OTP à 6 chiffres
Route::get('/forgot-password/verify-otp', [ForgotPasswordController::class, 'showOtpForm'])->name('password.otp.form');
Route::post('/forgot-password/verify-otp', [ForgotPasswordController::class, 'verifyOtp'])->name('password.otp.verify');
Route::post('/forgot-password/resend-otp', [ForgotPasswordController::class, 'resendResetOtp'])->name('password.otp.resend');

// Étape 3 : Saisie du nouveau mot de passe et confirmation
Route::get('/forgot-password/reset-password', [ResetPasswordController::class, 'showResetPasswordForm'])->name('password.reset.form');
Route::post('/forgot-password/reset-password', [ResetPasswordController::class, 'submitNewPassword'])->name('password.reset.submit');

// 5. Espace Membre (Dashboard, Mes Annonces & Mon Profil - Réservé aux connectés)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AnnonceController::class, 'dashboard'])->name('dashboard');
    Route::post('/annonces/store', [AnnonceController::class, 'store'])->name('annonces.store');
    Route::delete('/annonces/{id}', [AnnonceController::class, 'destroy'])->name('annonces.destroy');
    Route::post('/profile/update', [AuthController::class, 'updateProfile'])->name('profile.update');
});

// 6. Page client public (Profil d'un vendeur et ses annonces mises en vente)
Route::get('/page-client/{id?}', [AnnonceController::class, 'showClientProfile'])->name('page_client');
Route::get('/client/{id?}', [AnnonceController::class, 'showClientProfile']);
Route::get('/espace-client', function () {
    return redirect()->route('dashboard');
});

// 7. Route de validation d'envoi d'e-mail de test via SMTP Gmail
Route::get('/test-email', function () {
    try {
        Mail::raw('Test d\'envoi d\'e-mail réussi depuis la plateforme Epsilon via Gmail !', function ($message) {
            $message->to('amenouglofrancesco0@gmail.com')
                    ->subject('Test SMTP Gmail Epsilon');
        });
        return response()->json([
            'status' => 'success',
            'message' => 'E-mail envoyé avec succès ! Vérifiez votre boîte Gmail.'
        ]);
    } catch (\Throwable $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage()
        ], 500);
    }
})->name('test.email');
