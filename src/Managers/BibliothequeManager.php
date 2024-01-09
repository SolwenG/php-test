<?php

namespace App\Managers;

use App\Abstracts\ItemBibliotheque;
use App\Exceptions\LivreException;
use App\Interfaces\Recherchable;
use App\Traits\Loggable;
use App\Models\Livre;
use App\Models\LivreSpecialise;

class BibliothequeManager implements Recherchable
{
    use Loggable;

    const CATEGORIE_DEFAUT = "Général";

    private array $livres;
    private array $genresDisponibles;

    public function __construct()
    {
        $this->livres = [];
        $this->genresDisponibles = ["Science-fiction", "Histoire", "Art", "Technologie", "Roman"];
        $this->chargerLivresInitiaux();
    }

    private function chargerLivresInitiaux()
    {
        $this->ajouterLivre("L'Etranger", "Albert Camus", 1942, "Roman");
        $this->ajouterLivre("Le Petit Prince", "Antoine de Saint-Exupéry", 1943, "Roman");
        $this->ajouterLivre("22/11/63", "Stephen King", 2011, "Science-fiction");
    }

    public function ajouterLivre(string $titre, string $auteur, int $anneePublication, ?string $genre = null): void
    {
        try {
            $this->verifierEtAjouterGenre($genre ?? self::CATEGORIE_DEFAUT);

            if (!self::validerAnneePublication($anneePublication)) {
                throw new LivreException("L'année de publication doit comporter 4 chiffres.");
            }

            $livre = $genre ? new LivreSpecialise($titre, $auteur, $anneePublication, $genre)
                : new Livre($titre, $auteur, $anneePublication);
            $this->livres[] = $livre;
        } catch (\Exception $e) {
            throw new LivreException("Erreur lors de l'ajout du livre : " . $e->getMessage());
        }
    }

    // Méthode statique pour valider l'année de publication
    public static function validerAnneePublication(int $annee): bool
    {
        return strlen((string)$annee) === 4;
    }

    private function verifierEtAjouterGenre(?string $genre): void
    {
        if ($genre && !in_array($genre, $this->genresDisponibles)) {
            $this->genresDisponibles[] = $genre;
        }
    }

    public function ajouterGenre(string $nouveauGenre): void
    {
        if (!in_array($nouveauGenre, $this->genresDisponibles)) {
            $this->genresDisponibles[] = $nouveauGenre;
        }
    }

    public function supprimerGenre(string $genre): void
    {
        $this->genresDisponibles = array_filter($this->genresDisponibles, function ($d) use ($genre) {
            return $d !== $genre;
        });
    }

    public function getGenresDisponibles(): array
    {
        return $this->genresDisponibles;
    }

    public function rechercherParTitre(string $motCle): array
    {
        $resultats = [];
        foreach ($this->livres as $livre) {
            if (strpos(strtolower($livre->getTitre()), strtolower($motCle)) !== false) {
                $resultats[] = $livre;
            }
        }
        return $resultats;
    }

    public function rechercher(string $motCle): array
    {
        return $this->rechercherParTitre($motCle);
    }

    public function rechercherParGenre(array $genres): array
    {
        $resultats = [];
        foreach ($this->livres as $livre) {
            if (in_array(null, $genres) && !$livre instanceof LivreSpecialise) {
                $resultats[] = $livre;
            } elseif ($livre instanceof LivreSpecialise && in_array($livre->getGenre(), $genres)) {
                $resultats[] = $livre;
            }
        }
        return $resultats;
    }

    public function getLivres(): array
    {
        return $this->livres;
    }
}
