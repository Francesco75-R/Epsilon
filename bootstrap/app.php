<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Validation\ValidationException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->redirectGuestsTo(function (Request $request) {
            if ($request->is('admin') || $request->is('admin/*')) {
                return route('admin.login');
            }
            return route('login');
        });
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // 1. Authentification (401 Unauthorized)
        $exceptions->render(function (AuthenticationException $e, Request $request) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'status' => 'error',
                    'code' => 401,
                    'message' => 'Non authentifié. Veuillez vous connecter pour accéder à cette ressource.'
                ], 401);
            }

            if ($request->is('admin') || $request->is('admin/*')) {
                return redirect()->guest(route('admin.login'))
                    ->with('error', 'Accès restreint. Veuillez vous connecter en tant qu\'administrateur.');
            }

            return redirect()->guest(route('login'))
                ->with('error', 'Veuillez vous connecter pour accéder à cet espace.');
        });

        // 2. Autorisation (403 Forbidden)
        $exceptions->render(function (AccessDeniedHttpException $e, Request $request) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'status' => 'error',
                    'code' => 403,
                    'message' => $e->getMessage() ?: 'Accès interdit. Vous ne disposez pas des privilèges requis.'
                ], 403);
            }
            return response()->view('errors.403', ['message' => $e->getMessage()], 403);
        });

        $exceptions->render(function (AuthorizationException $e, Request $request) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'status' => 'error',
                    'code' => 403,
                    'message' => $e->getMessage() ?: 'Accès interdit. Action non autorisée.'
                ], 403);
            }
            return response()->view('errors.403', ['message' => $e->getMessage()], 403);
        });

        // 3. Ressources / Routes introuvables (404 Not Found)
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'status' => 'error',
                    'code' => 404,
                    'message' => 'Ressource introuvable sur Epsilon.'
                ], 404);
            }
            return response()->view('errors.404', [], 404);
        });

        // 4. Session expirée / Token CSRF (419 Page Expired)
        $exceptions->render(function (TokenMismatchException $e, Request $request) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'status' => 'error',
                    'code' => 419,
                    'message' => 'Votre session a expiré ou le jeton CSRF est invalide. Veuillez rafraîchir la page et réessayer.'
                ], 419);
            }
            return response()->view('errors.419', [], 419);
        });

        $exceptions->render(function (HttpException $e, Request $request) {
            if ($e->getStatusCode() === 419) {
                if ($request->expectsJson() || $request->is('api/*')) {
                    return response()->json([
                        'status' => 'error',
                        'code' => 419,
                        'message' => 'Votre session a expiré ou le jeton CSRF est invalide. Veuillez rafraîchir la page et réessayer.'
                    ], 419);
                }
                return response()->view('errors.419', [], 419);
            }
            return null;
        });

        // 5. Validation des données entrantes (422 Unprocessable Entity) pour les API/JSON
        $exceptions->render(function (ValidationException $e, Request $request) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'status' => 'error',
                    'code' => 422,
                    'message' => 'Les données transmises sont invalides.',
                    'errors' => $e->errors(),
                ], 422);
            }
            // Pour le web standard, continuer avec le comportement par défaut (redirection back avec erreurs)
            return null;
        });

        // 6. Gestion centralisée des erreurs inattendues (500 Internal Server Error)
        $exceptions->render(function (\Throwable $e, Request $request) {
            // Ignorer les exceptions HTTP standard qui ont déjà leur propre rendu
            if ($e instanceof HttpException) {
                return null;
            }

            // Journalisation systématique côté serveur pour débogage et traçabilité
            Log::error('Erreur Serveur [500] : ' . $e->getMessage(), [
                'exception' => get_class($e),
                'file'      => $e->getFile(),
                'line'      => $e->getLine(),
                'url'       => $request->fullUrl(),
                'method'    => $request->method(),
                'ip'        => $request->ip(),
                'user_id'   => optional($request->user())->id,
            ]);

            // Retour JSON sécurisé sans fuite de secrets ou de stack trace
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'status'  => 'error',
                    'code'    => 500,
                    'message' => config('app.debug') 
                        ? $e->getMessage() 
                        : 'Une erreur interne inattendue s\'est produite. Nos équipes techniques ont été notifiées.'
                ], 500);
            }

            // En mode production (ou debug false), renvoyer la vue d'erreur 500 personnalisée
            if (!config('app.debug')) {
                return response()->view('errors.500', [], 500);
            }

            // En mode local de développement (debug true), laisser Laravel afficher le débogueur détaillé
            return null;
        });
    })->create();
