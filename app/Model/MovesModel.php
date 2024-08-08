<?php

namespace App\Model;

use App\Core\HttpResponse;
use App\Core\Model;

class MovesModel extends Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index($page, $perPage): void
    {
        try {
            // Paginación
            $pagination = $this->pagination("SELECT COUNT(id) AS totalRows FROM moves", $page, $perPage);

            // Información
            $results = $this->customQuery("SELECT name FROM moves", $page, $perPage)->get();

            die(HttpResponse::status200($results, $pagination));
        } catch (\mysqli_sql_exception $e) {
            error_log("Pokemon::getPokemon -> {$e->getMessage()}");
            die(HttpResponse::status500(["message" => "Ha ocurrido un error en el servidor"]));
        }
    }
}
