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

    public function index($page, $perPage): void
    {
        try {
            // Paginación
            $pagination = $this->pagination("SELECT COUNT(id) AS totalRows FROM pokemon", $page, $perPage);

            // Información
            $currentURL = getCurrentURL(true);
            $results = $this->customQuery("SELECT name, CONCAT('$currentURL/', id) AS url FROM pokemon", $page, $perPage)->get();

            die(HttpResponse::status200($results, $pagination));
        } catch (\mysqli_sql_exception $e) {
            error_log("Pokemon::getPokemon -> {$e->getMessage()}");
            die(HttpResponse::status500(["message" => "Ha ocurrido un error en el servidor"]));
        }
    }

    public function show($id): void
    {
        try {
            $results = [];
            $results = $this->customQuery("SELECT name, image FROM pokemon WHERE id = $id")->get()[0];

            // No existe el pokemon
            if (empty($results)) {
                die(HttpResponse::status404(["message" => "404 Not Found"]));
            }

            $results["stats"] = $this->customQuery("SELECT name, base_stat FROM pokemon_stat_view WHERE pokemon_id = $id")->get();
            $results["types"] = $this->customQuery("SELECT name FROM pokemon_type_view WHERE pokemon_id = $id")->get();
            $results["moves"] = $this->customQuery("SELECT name FROM pokemon_move_view WHERE pokemon_id = $id")->get();
            $results["abilities"] = $this->customQuery("SELECT name FROM pokemon_ability_view WHERE pokemon_id = $id")->get();

            HttpResponse::status200($results);
        } catch (\mysqli_sql_exception $e) {
            error_log("Pokemon::getPokemon -> {$e->getMessage()}");
            HttpResponse::status500(["message" => "Ha ocurrido un error en el servidor"]);
        }
    }
}
