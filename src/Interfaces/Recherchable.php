<?php

namespace App\Interfaces;

interface Recherchable
{
    public function rechercher(string $motCle): array;
}
