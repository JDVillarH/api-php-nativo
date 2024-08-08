<?php

namespace App\Model;

use App\Core\HttpResponse;
use App\Core\Model;

class TypesModel extends Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index($perPageParam, $pageParam): void
    {
        try {
            // Paginación
            $sqlCountRows = $this->customSingleQuery("SELECT COUNT(id) AS totalRows FROM types")->first();
            $pagination = $this->pagination($perPageParam, $pageParam, $sqlCountRows->totalRows);

            // Información
            $sqlQueryPokemon = "SELECT name FROM types";
            $results = $this->customSingleQuery($sqlQueryPokemon, $perPageParam)->get();

            HttpResponse::status200($results, $pagination);
        } catch (\mysqli_sql_exception $e) {
            error_log("Pokemon::getPokemon -> {$e->getMessage()}");
            HttpResponse::status500(["message" => "Ha ocurrido un error en el servidor"]);
        }
    }
}
