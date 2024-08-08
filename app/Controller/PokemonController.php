<?php

namespace App\Controller;

use App\Model\PokemonModel;

class PokemonController
{
    public static function index()
    {
        $pageParam = getIntegerParam("page", 1);
        $perPageParam = getIntegerParam("perPage", 20);

        $pokemonModel = new PokemonModel();
        return $pokemonModel->index($perPageParam, $pageParam);
    }

    public static function show(int $id)
    {
        $pokemonModel = new PokemonModel();
        return $pokemonModel->show($id);
    }
}
