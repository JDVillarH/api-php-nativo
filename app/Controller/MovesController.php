<?php

namespace App\Controller;

use App\Model\MovesModel;

class MovesController extends Controller
{
    public static function index(): void
    {
        // Validar los parámetros de la URL
        $validation = self::validate($_GET, ["page" => "integer|min:1", "perPage" => "integer|min:1|max:100"]);

        // Obtener los datos de la URL
        $page = $validation->getValidData()["page"] ?? 1;
        $perPage = $validation->getValidData()["perPage"] ?? 20;

        // Ejecutar la acción
        $movesModel = new MovesModel();
        $movesModel->index($page, $perPage);
    }
}
