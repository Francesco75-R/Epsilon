<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Verification extends Model
{
    use HasFactory;

    protected $table = 'verifications';

    /**
     * La table utilise uniquement created_at et verified_at (pas de updated_at).
     */
    public const UPDATED_AT = null;

    protected $fillable = [
        'user_id',
        'photo',
        'carte',
        'status',
        'created_at',
        'verified_at',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'verified_at' => 'datetime',
        ];
    }

    /**
     * Automatisation Eloquent :
     * Dès que status passe à "verifier" :
     * 1. La colonne verified_at se remplit automatiquement avec la date/heure actuelle.
     * 2. La colonne profil de la table users passe automatiquement de "client" à "vendeur".
     */
    protected static function booted(): void
    {
        static::saving(function (Verification $verification) {
            if ($verification->isVerifiedStatus()) {
                if (is_null($verification->verified_at)) {
                    $verification->verified_at = now();
                }
            } else {
                $verification->verified_at = null;
            }
        });

        static::saved(function (Verification $verification) {
            if ($verification->isVerifiedStatus()) {
                User::where('id', $verification->user_id)->update(['profil' => 'vendeur']);
            } else {
                User::where('id', $verification->user_id)->update(['profil' => 'client']);
            }
        });
    }

    /**
     * Indique si le statut correspond à un dossier validé ("verifier").
     */
    public function isVerifiedStatus(): bool
    {
        return in_array(mb_strtolower(trim((string) $this->status)), ['verifier', 'vérifié', 'verifie', 'approved'], true);
    }

    /**
     * Méthode utilitaire pour valider la demande depuis le futur contrôleur Admin :
     * Passe status à "verifier", remplit verified_at et mute automatiquement l'utilisateur en "vendeur".
     */
    public function valider(): bool
    {
        $this->status = 'verifier';
        $this->verified_at = now();

        return $this->save();
    }

    /**
     * Relation : Une demande de vérification appartient à un utilisateur.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
