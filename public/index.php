<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Managers\BibliothequeManager;
use App\Helpers\UIHelper;

$manager = new BibliothequeManager();

while (true) {
    UIHelper::afficherMenu();
    $choix = readline();

    switch ($choix) {
        case "1":
            $titre = readline("Entrez le titre : ");
            $auteur = readline("Entrez l'auteur : ");
            $anneePublicationStr = readline("Entrez l'année de publication : ");
            $genre = readline("Entrez le genre (ou laissez vide) : ");

            $anneePublication = filter_var($anneePublicationStr, FILTER_VALIDATE_INT, [
                "options" => [
                    "min_range" => 1800,
                    "max_range" => 2100
                ]
            ]);

            if ($anneePublication === false) {
                echo "L'année de publication n'est pas valide. Echec de l'ajout.\n";
                break;
            }

            $manager->ajouterLivre($titre, $auteur, $anneePublication, $genre);
            break;

        case "2":
            $livres = $manager->getLivres();
            echo "\n Liste des livres : \n";
            UIHelper::afficherLivresSousFormeDeTableau($livres);
            break;

        case "3":
            $motCle = readline("Entrez le titre à rechercher : ");
            $resultats = $manager->rechercherParTitre($motCle);
            echo "\n Résultats de la recherche par titre : \n";
            UIHelper::afficherLivresSousFormeDeTableau($resultats);
            break;

        case "4":
            echo "\n Genres disponibles : \n";
            UIHelper::afficherGenres($manager->getGenresDisponibles());
            $indicesGenres = explode(',', readline("Choisissez les numéros des genres (séparés par une virgule, '0' pour sans genre) : "));
            $genresChoisis = [];

            foreach ($indicesGenres as $indice) {
                if ($indice == "0") {
                    $genresChoisis[] = null;
                } else {
                    $genre = $manager->getGenresDisponibles()[$indice - 1] ?? null;
                    if ($genre) {
                        $genresChoisis[] = $genre;
                    }
                }
            }

            $resultats = $manager->rechercherParGenre($genresChoisis);
            echo "\n Résultats de la recherche par genre : \n";
            UIHelper::afficherLivresSousFormeDeTableau($resultats);
            break;

        case "5":
            exit("\033[1;32mFin du programme.\n\033[0m");

        default:
            echo "\033[1;31mOption non valide. Veuillez réessayer.\n\033[0m";
    }
}
