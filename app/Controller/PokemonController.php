<?php

namespace App\Controller;

use App\Model\PokemonModel;

class PokemonController extends Controller
{
    public static function index(): void
    {
        // Validar los parámetros de la URL
        $validation = self::validate($_GET, ["page" => "integer|min:1", "perPage" => "integer|min:1|max:100"]);

        // Obtener los datos de la URL
        $page = $validation->getValidData()["page"] ?? 1;
        $perPage = $validation->getValidData()["perPage"] ?? 20;

        // Ejecutar la acción
        $pokemonModel = new PokemonModel();
        $pokemonModel->index($page, $perPage);
    }

    public static function show($id)
    {
        // Validar los parámetros de la URL
        $validation = self::validate(compact("id"), ["id" => "integer|min:1"]);

        // Obtener los datos de la URL
        $id = $validation->getValidData()["id"];

        // Ejecutar la acción
        $pokemonModel = new PokemonModel();
        return $pokemonModel->show($id);
    }
}
