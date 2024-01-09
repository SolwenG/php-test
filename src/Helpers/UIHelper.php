<?php

namespace App\Helpers;

use App\Models\LivreSpecialise;

class UIHelper
{
    public static function afficherGenres($genresDisponibles)
    {
        foreach ($genresDisponibles as $index => $genre) {
            echo ($index + 1) . ". $genre\n";
        }
    }

    public static function afficherLivresSousFormeDeTableau($livres)
    {
        echo "\033[1;34m"; // Couleur bleue
        echo str_pad("Titre", 40) . str_pad("Auteur", 30) . str_pad("Année", 10) . str_pad("Genre", 20) . "\n";
        echo "\033[0m"; // Réinitialiser le style

        foreach ($livres as $livre) {
            echo str_pad($livre->getTitre(), 40);
            echo str_pad($livre->getAuteur(), 30);
            echo str_pad($livre->getAnneePublication(), 10);
            $genre = ($livre instanceof LivreSpecialise) ? $livre->getGenre() : "Sans genre";
            echo str_pad($genre, 20);
            echo "\n";
        }
    }

    public static function afficherMenu()
    {
        echo "\033[1;33m\n"; // Couleur jaune
        echo "1. Ajouter un livre\n";
        echo "2. Lister tous les livres\n";
        echo "3. Rechercher un livre par titre\n";
        echo "4. Rechercher un livre par genre\n";
        echo "5. Quitter\n";
        echo "\033[0m"; // Réinitialiser le style
        echo "Choisissez une option : ";
    }
}
