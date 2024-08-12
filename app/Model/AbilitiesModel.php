<?php

namespace App\Model;

use App\Core\HttpResponse;
use App\Core\Model;

class AbilitiesModel extends Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index($page, $limit): void
    {
        try {
            // Paginación
            $pagination = $this->pagination("SELECT COUNT(id) AS totalRows FROM abilities", $page, $limit);

            // Información
            $results = $this->customQuery("SELECT * FROM abilities", $page, $limit)->get();

            die(HttpResponse::status200($results, $pagination));
        } catch (\mysqli_sql_exception $e) {
            error_log("AbilitiesModel->index -> {$e->getMessage()}");
            die(HttpResponse::status500(["message" => "Ha ocurrido un error en el servidor"]));
        }
    }
}
