<?php

namespace App\Model;

use App\Core\HttpResponse;
use App\Core\Model;

class PokemonModel extends Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index($perPageParam, $pageParam): void
    {
        try {
            $currentURL = getCurrentURL(true);

            // Paginación
            $sqlCountRows = $this->customSingleQuery("SELECT COUNT(id) AS totalRows FROM pokemon")->first();
            $pagination = $this->pagination($perPageParam, $pageParam, $sqlCountRows->totalRows);

            // Información
            $sqlQueryPokemon = "SELECT name, CONCAT('$currentURL/', id) AS url FROM pokemon";
            $results = $this->customSingleQuery($sqlQueryPokemon, $perPageParam)->get();

            HttpResponse::status200($results, $pagination);
        } catch (\mysqli_sql_exception $e) {
            error_log("Pokemon::getPokemon -> {$e->getMessage()}");
            HttpResponse::status500(["message" => "Ha ocurrido un error en el servidor"]);
        }
    }

    public function show($id): void
    {
        try {
            $results = [];
            $results = $this->customSingleQuery("SELECT name, image FROM pokemon WHERE id = $id")->get()[0];
            $results["stats"] = $this->customSingleQuery("SELECT name, base_stat FROM pokemon_stat_view WHERE pokemon_id = $id")->get();
            $results["types"] = $this->customSingleQuery("SELECT name FROM pokemon_type_view WHERE pokemon_id = $id")->get();
            $results["moves"] = $this->customSingleQuery("SELECT name FROM pokemon_move_view WHERE pokemon_id = $id")->get();
            $results["abilities"] = $this->customSingleQuery("SELECT name FROM pokemon_ability_view WHERE pokemon_id = $id")->get();

            HttpResponse::status200($results);
        } catch (\mysqli_sql_exception $e) {
            error_log("Pokemon::getPokemon -> {$e->getMessage()}");
            HttpResponse::status500(["message" => "Ha ocurrido un error en el servidor"]);
        }
    }
}
