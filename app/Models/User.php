<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'telephone',
        'adresse',
        'genre',
        'photo',
        'profil',
        'password',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Les annonces publiées par l'utilisateur.
     */
    public function annonces()
    {
        return $this->hasMany(Annonce::class);
    }

    /**
     * Toutes les demandes de vérification de l'utilisateur.
     */
    public function verifications()
    {
        return $this->hasMany(Verification::class);
    }

    /**
     * La dernière demande de vérification de l'utilisateur.
     */
    public function verification()
    {
        return $this->hasOne(Verification::class)->latestOfMany();
    }

    /**
     * Synchronise automatiquement le profil de l'utilisateur avec sa dernière demande de vérification :
     * Si la demande dans `verifications` a le statut "verifier", `users.profil` passe à "vendeur"
     * et `verifications.verified_at` est renseigné s'il était vide.
     */
    public function syncVerificationStatus(): void
    {
        $latestVerification = $this->verification()->first();

        if (!$latestVerification) {
            return;
        }

        if ($latestVerification->isVerifiedStatus()) {
            if (is_null($latestVerification->verified_at)) {
                $latestVerification->verified_at = now();
                $latestVerification->saveQuietly();
            }

            if ($this->profil !== 'vendeur') {
                $this->profil = 'vendeur';
                $this->saveQuietly();
            }
        } elseif ($this->profil === 'vendeur') {
            $this->profil = 'client';
            $this->saveQuietly();
        }
    }

    /**
     * Vérifie si l'utilisateur a un compte vendeur vérifié (profil = 'vendeur' et demande au statut 'verifier').
     */
    public function canPublishAnnonce(): bool
    {
        $this->syncVerificationStatus();

        if (($this->profil ?? 'client') !== 'vendeur') {
            return false;
        }

        $latestVerification = $this->verification()->first();

        return $latestVerification !== null
            && !empty($latestVerification->carte)
            && $latestVerification->isVerifiedStatus();
    }
}
