<?php

namespace App\Models;

class LivreSpecialise extends Livre
{
    protected $genre;

    public function __construct($titre, $auteur, $anneePublication, $genre)
    {
        parent::__construct($titre, $auteur, $anneePublication);
        $this->genre = $genre;
    }

    public function getGenre()
    {
        return $this->genre;
    }

    public function afficherInfos()
    {
        parent::afficherInfos();
        echo "Genre : " . $this->genre . "\n";
    }
}
