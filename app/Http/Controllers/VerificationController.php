<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Verification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class VerificationController extends Controller
{
    /**
     * Affiche le formulaire de vérification de compte pour passer au profil Vendeur.
     */
    public function create()
    {
        /** @var User $user */
        $user = Auth::user();
        $user->syncVerificationStatus();

        $latestVerification = $user->verification()->first();

        return view('profile.verify', compact('user', 'latestVerification'));
    }

    /**
     * Enregistre la demande de vérification (Selfie + Carte d'identité) avec le statut "En cours".
     * Le profil dans `users` reste "client" et `verified_at` reste NULL tant que l'admin n'a pas validé.
     */
    public function store(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,webp|max:10240',
            'carte' => 'required|image|mimes:jpeg,png,jpg,webp|max:10240',
        ], [
            'photo.required' => 'Veuillez téléverser un selfie clair de votre visage.',
            'photo.image'    => 'Le selfie doit être une image valide (JPG, PNG ou WEBP). Les fichiers PDF sont interdits.',
            'photo.mimes'    => 'Format du selfie non autorisé. Utilisez uniquement JPG, JPEG, PNG ou WEBP.',
            'photo.max'      => 'La taille du selfie ne doit pas dépasser 10 Mo.',
            'carte.required' => 'Veuillez téléverser la photo de votre carte d\'identité.',
            'carte.image'    => 'La carte d\'identité doit être une image (JPG, PNG ou WEBP). Les fichiers PDF sont strictement interdits.',
            'carte.mimes'    => 'Format de la carte d\'identité non autorisé (PDF strictement interdit). Utilisez uniquement JPG, JPEG, PNG ou WEBP.',
            'carte.max'      => 'La taille de la photo de la carte d\'identité ne doit pas dépasser 10 Mo.',
        ]);

        /** @var User $user */
        $user = Auth::user();

        try {
            // 1. Sauvegarde du selfie dans public/photo
            $photoDir = public_path('photo');
            if (!is_dir($photoDir)) {
                mkdir($photoDir, 0755, true);
            }
            $photoFile = $request->file('photo');
            $photoFilename = 'selfie_' . $user->id . '_' . time() . '_' . uniqid() . '.' . $photoFile->getClientOriginalExtension();
            $photoFile->move($photoDir, $photoFilename);
            $photoPath = 'photo/' . $photoFilename;

            // 2. Sauvegarde de la carte d'identité dans public/carte
            $carteDir = public_path('carte');
            if (!is_dir($carteDir)) {
                mkdir($carteDir, 0755, true);
            }
            $carteFile = $request->file('carte');
            $carteFilename = 'carte_' . $user->id . '_' . time() . '_' . uniqid() . '.' . $carteFile->getClientOriginalExtension();
            $carteFile->move($carteDir, $carteFilename);
            $cartePath = 'carte/' . $carteFilename;

            // 3. Enregistrement dans la table `verifications` avec status = "En cours" et verified_at = null
            Verification::create([
                'user_id'     => $user->id,
                'photo'       => $photoPath,
                'carte'       => $cartePath,
                'status'      => 'En cours',
                'created_at'  => now(),
                'verified_at' => null,
            ]);

            return redirect()->route('dashboard')
                ->with('success', 'Votre demande de vérification a été envoyée avec succès (Statut : En cours). Votre compte passera automatiquement en Vendeur dès validation.');
        } catch (\Throwable $e) {
            Log::error('Erreur soumission vérification vendeur : ' . $e->getMessage(), ['exception' => $e]);
            return redirect()->back()
                ->withInput()
                ->with('error', 'Une erreur inattendue est survenue lors de l\'enregistrement de vos documents. Veuillez réessayer.');
        }
    }

    /**
     * Action de validation administrative :
     * - Change `verifications.status` en "verifier"
     * - Remplit automatiquement `verifications.verified_at` avec la date actuelle
     * - Change automatiquement `users.profil` de "client" à "vendeur"
     * - Envoie un e-mail officiel de félicitations et d'acceptation au client
     */
    public function valider($id)
    {
        $verification = Verification::with('user')->findOrFail($id);
        $verification->valider();

        $user = $verification->user;
        $emailSent = false;

        if ($user && !empty($user->email)) {
            try {
                $dashboardUrl = route('dashboard');
                $newAdUrl = route('annonces.create');
                $nomComplet = trim(($user->prenom ?? '') . ' ' . ($user->nom ?? ''));

                $html = '
                <div style="font-family: \'Plus Jakarta Sans\', Arial, sans-serif; max-width: 600px; margin: 0 auto; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
                    <div style="background: #0A1128; padding: 28px 24px; text-align: center;">
                        <h1 style="color: #ffffff; margin: 0; font-size: 24px; font-weight: 800; letter-spacing: -0.5px;">Epsilon Marketplace</h1>
                        <p style="color: #10B981; margin: 6px 0 0 0; font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Félicitations • Compte Vendeur Validé</p>
                    </div>
                    <div style="padding: 32px 28px; background: #ffffff;">
                        <div style="text-align: center; margin-bottom: 24px;">
                            <div style="display: inline-block; width: 64px; height: 64px; line-height: 64px; border-radius: 50%; background: #ecfdf5; color: #006c4a; font-size: 32px; font-weight: bold; border: 2px solid #82f5c1;">✓</div>
                        </div>
                        <h2 style="font-size: 20px; color: #0f172a; margin: 0 0 12px 0; text-align: center; font-weight: 800;">Votre profil Vendeur est validé !</h2>
                        <p style="font-size: 15px; color: #334155; line-height: 1.6; margin: 0 0 16px 0;">
                            Bonjour <strong>' . htmlspecialchars($nomComplet) . '</strong>,
                        </p>
                        <p style="font-size: 14px; color: #475569; line-height: 1.7; margin: 0 0 20px 0;">
                            Nous avons le grand plaisir de vous informer que votre dossier de vérification d\'identité a été examiné et <strong>approuvé avec succès</strong> par l\'équipe d\'administration d\'Epsilon Marketplace.
                        </p>
                        <div style="background: #f8fafc; border-left: 4px solid #10B981; padding: 16px 20px; border-radius: 0 10px 10px 0; margin-bottom: 24px;">
                            <p style="font-size: 13.5px; color: #1e293b; margin: 0; line-height: 1.6;">
                                <strong>Vos nouveaux privilèges Vendeur :</strong><br>
                                • Statut officiel de <strong>Vendeur Certifié</strong><br>
                                • Badge de confiance visible par tous les acheteurs<br>
                                • Dépôt illimité de vos annonces de vente
                            </p>
                        </div>
                        <div style="text-align: center; margin: 28px 0 24px 0;">
                            <a href="' . $newAdUrl . '" style="display: inline-block; background: #006c4a; color: #ffffff; text-decoration: none; padding: 13px 28px; font-weight: 700; font-size: 14px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,108,74,0.25);">Déposer une annonce maintenant →</a>
                        </div>
                        <p style="font-size: 13px; color: #64748b; text-align: center; margin: 16px 0 0 0;">
                            Vous pouvez gérer vos annonces et votre profil depuis votre <a href="' . $dashboardUrl . '" style="color: #006c4a; font-weight: 600; text-decoration: underline;">Espace Membre</a>.
                        </p>
                    </div>
                    <div style="background: #f8fafc; padding: 18px 24px; text-align: center; border-top: 1px solid #e2e8f0; font-size: 12px; color: #64748b;">
                        © ' . date('Y') . ' Epsilon Marketplace Togo. Tous droits réservés.<br>
                        Transactions directes, locales et sécurisées.
                    </div>
                </div>';

                Mail::html($html, function ($message) use ($user, $nomComplet) {
                    $message->to($user->email, $nomComplet)
                            ->subject('🎉 Félicitations ! Votre compte Vendeur a été validé sur Epsilon');
                });

                $emailSent = true;
            } catch (\Throwable $e) {
                Log::error('Erreur SMTP lors de l\'envoi de l\'email de validation vendeur : ' . $e->getMessage());
            }
        }

        $message = 'La demande a été validée avec succès : le profil de l\'utilisateur est désormais "vendeur"';
        $message .= $emailSent ? ' et un e-mail de confirmation lui a été envoyé.' : '.';

        return back()->with('success', $message);
    }

    /**
     * Action de rejet administratif :
     * - Remet le statut à "Rejeté", `verified_at` à null et `users.profil` à "client"
     * - Envoie un e-mail explicatif et bienveillant de refus au client
     */
    public function rejeter(Request $request, $id)
    {
        $verification = Verification::with('user')->findOrFail($id);
        $verification->status = 'Rejeté';
        $verification->verified_at = null;
        $verification->save();

        $user = $verification->user;
        $emailSent = false;
        $motif = $request->input('motif', "La photo de la pièce d'identité ou le selfie fourni était flou, illisible ou non conforme à nos règles de sécurité.");

        if ($user && !empty($user->email)) {
            try {
                $verifyUrl = route('verification.create');
                $nomComplet = trim(($user->prenom ?? '') . ' ' . ($user->nom ?? ''));

                $html = '
                <div style="font-family: \'Plus Jakarta Sans\', Arial, sans-serif; max-width: 600px; margin: 0 auto; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
                    <div style="background: #0A1128; padding: 28px 24px; text-align: center;">
                        <h1 style="color: #ffffff; margin: 0; font-size: 24px; font-weight: 800; letter-spacing: -0.5px;">Epsilon Marketplace</h1>
                        <p style="color: #ef4444; margin: 6px 0 0 0; font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Statut de votre demande de vérification</p>
                    </div>
                    <div style="padding: 32px 28px; background: #ffffff;">
                        <div style="text-align: center; margin-bottom: 24px;">
                            <div style="display: inline-block; width: 64px; height: 64px; line-height: 64px; border-radius: 50%; background: #fef2f2; color: #dc2626; font-size: 28px; font-weight: bold; border: 2px solid #fecaca;">✕</div>
                        </div>
                        <h2 style="font-size: 20px; color: #0f172a; margin: 0 0 12px 0; text-align: center; font-weight: 800;">Information concernant votre demande</h2>
                        <p style="font-size: 15px; color: #334155; line-height: 1.6; margin: 0 0 16px 0;">
                            Bonjour <strong>' . htmlspecialchars($nomComplet) . '</strong>,
                        </p>
                        <p style="font-size: 14px; color: #475569; line-height: 1.7; margin: 0 0 20px 0;">
                            Après examen de votre dossier de vérification pour passer au profil Vendeur, nous vous informons que votre demande <strong>n\'a pas pu être validée</strong> par notre équipe de modération.
                        </p>
                        <div style="background: #fff1f2; border-left: 4px solid #ef4444; padding: 14px 18px; border-radius: 0 10px 10px 0; margin-bottom: 24px;">
                            <p style="font-size: 13.5px; color: #991b1b; margin: 0; line-height: 1.5;">
                                <strong>Motif :</strong> ' . htmlspecialchars($motif) . '
                            </p>
                        </div>
                        <p style="font-size: 14px; color: #475569; line-height: 1.6; margin: 0 0 24px 0;">
                            Vous pouvez soumettre un nouveau dossier à tout moment en vous assurant que votre selfie est net et que les informations de votre pièce d\'identité sont parfaitement lisibles.
                        </p>
                        <div style="text-align: center; margin: 28px 0 20px 0;">
                            <a href="' . $verifyUrl . '" style="display: inline-block; background: #0A1128; color: #ffffff; text-decoration: none; padding: 13px 28px; font-weight: 700; font-size: 14px; border-radius: 10px; box-shadow: 0 4px 10px rgba(10,17,40,0.25);">Soumettre un nouveau dossier →</a>
                        </div>
                    </div>
                    <div style="background: #f8fafc; padding: 18px 24px; text-align: center; border-top: 1px solid #e2e8f0; font-size: 12px; color: #64748b;">
                        © ' . date('Y') . ' Epsilon Marketplace Togo. Tous droits réservés.<br>
                        Notre équipe reste à votre disposition pour toute question.
                    </div>
                </div>';

                Mail::html($html, function ($message) use ($user, $nomComplet) {
                    $message->to($user->email, $nomComplet)
                            ->subject('Mise à jour concernant votre demande de statut Vendeur - Epsilon');
                });

                $emailSent = true;
            } catch (\Throwable $e) {
                Log::error('Erreur SMTP lors de l\'envoi de l\'email de rejet vendeur : ' . $e->getMessage());
            }
        }

        $message = 'La demande a été rejetée';
        $message .= $emailSent ? ' et un e-mail explicatif a été envoyé à l\'utilisateur.' : '.';

        return back()->with('error', $message);
    }
}
