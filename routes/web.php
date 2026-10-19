<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\insert_users;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes - Epsilon Marketplace
|--------------------------------------------------------------------------
| 1. Page d'accueil publique (Visiteurs non connectés : header_index avec bouton "Se connecter")
| 2. Espace Client connecté (Récupération de l'ID client et affichage de la photo de profil)
| 3. Authentification & Inscription
*/

// 1. Page d'accueil publique (Header_index avec bouton "Se connecter")
Route::get('/', function () {
    return view('index');
})->name('home');

// 2. Authentification & Inscription
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 3. Traitement Inscription Client
Route::post('/insert_client', [insert_users::class, 'store'])->name('insert_client.store');
Route::post('/register-client', [insert_users::class, 'store'])->name('register.store');

// 4. Espace Client (Connecté : Récupère l'ID du client connecté et affiche la page_client avec header)
Route::get('/page-client', function () {
    if (!Auth::check()) {
        return redirect()->route('login')->with('error', 'Veuillez vous connecter pour accéder à votre espace client.');
    }

    $clientId = Auth::id();
    $client = \App\Models\User::findOrFail($clientId);

    return view('page_client', compact('client'));
})->name('page_client');

Route::get('/client', function () {
    return redirect()->route('page_client');
});

Route::get('/espace-client', function () {
    return redirect()->route('page_client');
});
