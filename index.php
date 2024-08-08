<?php

use App\Controller\AbilitiesController;
use App\Controller\MovesController;
use App\Controller\PokemonController;
use App\Controller\TypesController;
use App\Core\ErrorLog;
use App\Core\HttpResponse;
use Bramus\Router\Router;

require_once "./vendor/autoload.php";
require_once "./app/config/constants.php";
require_once "./app/config/functions.php";

// Inicializa el enrutador
$router = new Router;

// Errores del sistema
ErrorLog::activateErrorLog();

// Respuestas HTTP
HttpResponse::httpResponse($router->getRequestMethod());

// Rutas
$router->mount("/api/v1", function () use ($router) {
    //Pokemon
    $router->get("/pokemon", [PokemonController::class, "index"]);
    $router->get("/pokemon/{id}", [PokemonController::class, "show"]);

    //Tipos
    $router->get("/types", [TypesController::class, "index"]);

    //Moves
    $router->get("/moves", [MovesController::class, "index"]);

    //Habilidades
    $router->get("/abilities", [AbilitiesController::class, "index"]);
});

// Ejecuta el enrutador
$router->run();
