<?php

namespace App\Models;

use App\Exceptions\LivreException;

class Livre
{
    protected $titre;
    protected $auteur;
    protected $anneePublication;

    public function __construct($titre, $auteur, $anneePublication)
    {
        // EXCEPTIONS
        if (empty($titre)) {
            throw new LivreException("Le titre est obligatoire.");
        }
        if (empty($auteur)) {
            throw new LivreException("L'auteur est obligatoire.");
        }
        if (!is_int($anneePublication)) {
            throw new LivreException("L'année de publication doit etre un nombre.");
        }

        $this->titre = $titre;
        $this->auteur = $auteur;
        $this->anneePublication = $anneePublication;
    }

    // GETTERS
    public function getTitre()
    {
        return $this->titre;
    }
    public function getAuteur()
    {
        return $this->auteur;
    }
    public function getAnneePublication()
    {
        return $this->anneePublication;
    }

    public function afficherInfos()
    {
        echo "Titre : " . $this->titre . ", Auteur : " . $this->auteur . ", Année de publication : " . $this->anneePublication . "\n";
    }
}
