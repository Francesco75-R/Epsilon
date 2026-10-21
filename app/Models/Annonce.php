<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Annonce extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'titre',
        'categorie',
        'etat',
        'lieu',
        'photos',
        'prix',
        'description',
    ];

    protected $casts = [
        'photos' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Formate la date de publication au format relatif personnalisé en français :
     * "Il y a 1 heure", "Il y a 2 j" (au lieu de 48h ou 369j), "Il y a 1 an", "Il y a 1 an 8 mois".
     */
    public function getFormattedDateAttribute(): string
    {
        if (!$this->created_at) {
            return 'Récemment';
        }

        $now = now();
        $diffMinutes = (int) $this->created_at->diffInMinutes($now);
        $diffHours = (int) $this->created_at->diffInHours($now);
        $diffDays = (int) $this->created_at->diffInDays($now);
        $diffMonths = (int) $this->created_at->diffInMonths($now);
        $diffYears = (int) $this->created_at->diffInYears($now);

        if ($diffMinutes < 1) {
            return "À l'instant";
        } elseif ($diffMinutes < 60) {
            return "Il y a {$diffMinutes} min";
        } elseif ($diffHours < 24) {
            return $diffHours === 1 ? "Il y a 1 heure" : "Il y a {$diffHours} heures";
        } elseif ($diffDays < 30) {
            return "Il y a {$diffDays} j";
        } elseif ($diffYears < 1) {
            return $diffMonths === 1 ? "Il y a 1 mois" : "Il y a {$diffMonths} mois";
        } else {
            $remainingMonths = $diffMonths % 12;
            if ($remainingMonths > 0) {
                return $diffYears === 1 
                    ? "Il y a 1 an {$remainingMonths} mois" 
                    : "Il y a {$diffYears} ans {$remainingMonths} mois";
            }
            return $diffYears === 1 ? "Il y a 1 an" : "Il y a {$diffYears} ans";
        }
    }
}
