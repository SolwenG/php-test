<?php

namespace App\Abstract;

abstract class ItemBibliotheque
{
    protected string $titre;

    public function __construct(string $titre)
    {
        $this->titre = $titre;
    }

    public function getTitre(): string
    {
        return $this->titre;
    }

    abstract public function afficherDetails(): string;
}
