<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Annonce;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Exception;

class AnnonceController extends Controller
{
    /**
     * Page d'accueil publique (index.blade.php) :
     * Affiche la liste globale des annonces filtrées dynamiquement avec comptages par catégorie.
     */
    public function index(Request $request)
    {
        $query = Annonce::with('user');

        // 1. Filtrage par mot-clé (sur titre et description)
        if ($request->filled('q')) {
            $keyword = trim($request->q);
            $query->where(function ($q) use ($keyword) {
                $q->where('titre', 'LIKE', "%{$keyword}%")
                  ->orWhere('description', 'LIKE', "%{$keyword}%");
            });
        }

        // 2. Filtrage par catégorie
        if ($request->filled('categorie') && $request->categorie !== 'all' && $request->categorie !== '') {
            $cat = trim($request->categorie);
            $query->where(function ($q) use ($cat) {
                $q->where('categorie', 'LIKE', "%{$cat}%");
                if (str_contains(strtolower($cat), 'tech')) {
                    $q->orWhere('categorie', 'LIKE', '%Smartphones%')
                      ->orWhere('categorie', 'LIKE', '%Électronique%');
                } elseif (str_contains(strtolower($cat), 'immo')) {
                    $q->orWhere('categorie', 'LIKE', '%Immobilier%');
                } elseif (str_contains(strtolower($cat), 'vehicule') || str_contains(strtolower($cat), 'véhicule')) {
                    $q->orWhere('categorie', 'LIKE', '%Véhicule%')
                      ->orWhere('categorie', 'LIKE', '%Vehicule%')
                      ->orWhere('categorie', 'LIKE', '%Auto%')
                      ->orWhere('categorie', 'LIKE', '%Moto%');
                } elseif (str_contains(strtolower($cat), 'maison')) {
                    $q->orWhere('categorie', 'LIKE', '%Maison%')
                      ->orWhere('categorie', 'LIKE', '%Mode%');
                } elseif (str_contains(strtolower($cat), 'service')) {
                    $q->orWhere('categorie', 'LIKE', '%Service%')
                      ->orWhere('categorie', 'LIKE', '%Emploi%');
                }
            });
        }

        // 3. Filtrage par localisation / ville
        if ($request->filled('lieu') && $request->lieu !== '' && !str_contains(strtolower($request->lieu), 'tout le togo')) {
            $lieu = trim($request->lieu);
            $query->where('lieu', 'LIKE', "%{$lieu}%");
        }

        // 4. Calcul du nombre total d'annonces correspondant aux filtres
        $totalCount = (clone $query)->count();

        // 5. Limitation par défaut aux 10 annonces les plus récentes (sauf demande d'affichage complet)
        $showAll = $request->boolean('all') || $request->input('limit') === 'all';
        $limit = $request->input('limit');

        if (!$showAll && (!$limit || !is_numeric($limit))) {
            $query->take(10);
        } elseif (is_numeric($limit)) {
            $query->take((int) $limit);
        }

        $annonces = $query->latest()->get();

        // 6. Comptages dynamiques réels de toutes les catégories du projet
        $categoryCounts = [
            'Véhicules' => Annonce::where('categorie', 'Véhicules')->count(),
            'Immobilier' => Annonce::where('categorie', 'Immobilier')->count(),
            'Smartphones & Tech' => Annonce::where('categorie', 'Smartphones & Tech')->count(),
            'Mode & Maison' => Annonce::where('categorie', 'Mode & Maison')->count(),
            'Emploi & Services' => Annonce::where('categorie', 'Emploi & Services')->count(),
            'vehicules' => Annonce::where(function ($q) {
                $q->where('categorie', 'LIKE', '%Véhicules%')
                  ->orWhere('categorie', 'LIKE', '%Vehicules%')
                  ->orWhere('categorie', 'LIKE', '%Auto%')
                  ->orWhere('categorie', 'LIKE', '%Moto%');
            })->count(),
            'immo' => Annonce::where('categorie', 'LIKE', '%Immobilier%')->count(),
            'tech' => Annonce::where(function ($q) {
                $q->where('categorie', 'LIKE', '%Smartphones & Tech%')
                  ->orWhere('categorie', 'LIKE', '%Tech%')
                  ->orWhere('categorie', 'LIKE', '%Électronique%');
            })->count(),
            'mode_maison' => Annonce::where(function ($q) {
                $q->where('categorie', 'LIKE', '%Mode & Maison%')
                  ->orWhere('categorie', 'LIKE', '%Mode%')
                  ->orWhere('categorie', 'LIKE', '%Maison%');
            })->count(),
            'services' => Annonce::where(function ($q) {
                $q->where('categorie', 'LIKE', '%Emploi & Services%')
                  ->orWhere('categorie', 'LIKE', '%Emploi%')
                  ->orWhere('categorie', 'LIKE', '%Services%');
            })->count(),
            'total' => Annonce::count(),
        ];

        return view('index', compact('annonces', 'categoryCounts', 'totalCount', 'showAll'));
    }

    /**
     * Espace Membre (dashboard.blade.php) :
     * Affiche le tableau de bord et filtre de manière stricte pour n'afficher QUE les annonces de l'utilisateur connecté.
     */
    public function dashboard(Request $request)
    {
        $user = Auth::user();
        $myAnnonces = Annonce::where('user_id', Auth::id())->latest()->get();

        return view('dashboard', compact('user', 'myAnnonces'));
    }

    /**
     * Page client public (page_client.blade.php) :
     * Affiche les informations d'un utilisateur spécifique et la liste de ses produits mis en vente (10 par défaut).
     */
    public function showClientProfile($id = null)
    {
        if ($id) {
            $client = User::findOrFail($id);
        } elseif (Auth::check()) {
            $client = Auth::user();
        } else {
            return redirect()->route('login')->with('error', 'Veuillez vous connecter pour accéder à votre espace.');
        }

        $query = Annonce::where('user_id', $client->id);
        $totalCount = (clone $query)->count();

        $showAll = request()->boolean('all') || request('limit') === 'all';
        $limit = request('limit');

        if (!$showAll && (!$limit || !is_numeric($limit))) {
            $query->take(10);
        } elseif (is_numeric($limit)) {
            $query->take((int) $limit);
        }

        $annonces = $query->latest()->get();

        return view('page_client', compact('client', 'annonces', 'totalCount', 'showAll'));
    }

    /**
     * Publication d'une nouvelle annonce (Store).
     * Stocke les photos physiques dans public/produit/ (jusqu'à 5 photos).
     */
    public function store(Request $request)
    {
        $messages = [
            'titre.required' => 'Le titre de l\'annonce est obligatoire.',
            'titre.max' => 'Le titre ne peut dépasser 150 caractères.',
            'categorie.required' => 'Veuillez sélectionner une catégorie.',
            'etat.required' => 'Veuillez indiquer l\'état du produit.',
            'lieu.required' => 'Le lieu / emplacement est obligatoire.',
            'photos.required' => 'Veuillez ajouter au moins une photo pour illustrer votre annonce.',
            'photos.min' => 'Veuillez ajouter au moins une photo.',
            'photos.max' => 'Vous ne pouvez pas envoyer plus de 5 photos par annonce.',
            'photos.*.image' => 'Chaque fichier doit être une image valide.',
            'photos.*.mimes' => 'Formats acceptés : JPG, JPEG, PNG, WEBP.',
            'photos.*.max' => 'Chaque photo ne doit pas dépasser 5 Mo.',
            'prix.required' => 'Le prix est obligatoire.',
            'prix.numeric' => 'Le prix doit être un nombre valide.',
            'prix.min' => 'Le prix doit être supérieur ou égal à 0.',
            'description.required' => 'La description détaillée est obligatoire.',
            'description.min' => 'La description doit comporter au moins 10 caractères.',
        ];

        $request->validate([
            'titre' => 'required|string|max:150',
            'categorie' => 'required|string',
            'etat' => 'required|string',
            'lieu' => 'required|string|max:100',
            'photos' => 'required|array|min:1|max:5',
            'photos.*' => 'image|mimes:jpeg,jpg,png,webp|max:5120',
            'prix' => 'required|numeric|min:0',
            'description' => 'required|string|min:10',
        ], $messages);

        try {
            // Création du dossier d'upload s'il n'existe pas
            $uploadDirectory = public_path('produit');
            if (!file_exists($uploadDirectory)) {
                mkdir($uploadDirectory, 0755, true);
            }

            $photoPaths = [];

            if ($request->hasFile('photos')) {
                // Les photos reçues respectent l'ordre ordonné par le glisser-déposer
                foreach ($request->file('photos') as $photo) {
                    $filename = time() . '_' . uniqid() . '.' . $photo->getClientOriginalExtension();
                    $photo->move($uploadDirectory, $filename);
                    $photoPaths[] = 'produit/' . $filename;
                }
            }

            // Normalisation de l'état
            $etat = $request->etat;
            if (str_contains(strtolower($etat), 'neuf')) {
                $etat = 'Neuf';
            } elseif (str_contains(strtolower($etat), 'usage') || str_contains(strtolower($etat), 'usagé') || str_contains(strtolower($etat), 'occasion')) {
                $etat = 'Usagé';
            }

            $annonce = Annonce::create([
                'user_id' => Auth::id(),
                'titre' => trim($request->titre),
                'categorie' => trim($request->categorie),
                'etat' => $etat,
                'lieu' => trim($request->lieu),
                'photos' => $photoPaths,
                'prix' => (int) $request->prix,
                'description' => trim($request->description),
            ]);

            return redirect()->route('dashboard', ['tab' => 'mes-annonces'])
                ->with('success', 'Félicitations ! Votre annonce « ' . $annonce->titre . ' » a été publiée avec succès.');

        } catch (Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Erreur lors de la publication : ' . $e->getMessage());
        }
    }

    /**
     * Suppression d'une annonce appartenant à l'utilisateur connecté.
     */
    public function destroy($id)
    {
        $annonce = Annonce::where('user_id', Auth::id())->findOrFail($id);

        // Suppression des fichiers physiques des photos
        if (is_array($annonce->photos)) {
            foreach ($annonce->photos as $path) {
                $fullPath = public_path($path);
                if (file_exists($fullPath) && is_file($fullPath)) {
                    @unlink($fullPath);
                }
            }
        }

        $annonce->delete();

        return redirect()->route('dashboard', ['tab' => 'mes-annonces'])
            ->with('success', 'L\'annonce a été supprimée avec succès.');
    }
}
