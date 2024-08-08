<?php

namespace App\Core;

class HttpResponse
{
    private static $httpResponse = [];
    private static $allowedDomains = ["localhost", "127.0.0.1"];

    final public static function httpResponse(string $method)
    {
        header('Content-Type: application/json');
        $origin = APP_ENV == "local" ? "localhost" : ($_SERVER['HTTP_ORIGIN'] ?? "");

        if ($origin === "") {
            die(self::status401(["message" => "No tiene permisos para consumir este recurso"]));
        }

        if (in_array($origin, self::$allowedDomains)) {

            header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Authorization");

            if ($method === "OPTIONS") {
                header("Access-Control-Allow-Origin: $origin");
                header('Access-Control-Allow-Methods: GET, PUT, POST, PATCH, DELETE');
                exit;
            } else {
                header("Access-Control-Allow-Origin: $origin");
                header('Access-Control-Allow-Methods: GET, PUT, POST, PATCH, DELETE');
                header("Allow: GET, POST, OPTIONS, PUT, PATCH , DELETE");
            }
        }
    }

    final public static function status200(array $results, array $pagination = null): void
    {

        self::$httpResponse['status'] = 200;
        if (!is_null($pagination)) {
            self::$httpResponse['pagination'] = $pagination;
        }
        self::$httpResponse['results'] = $results;

        http_response_code(200);
        echo json_encode(self::$httpResponse, JSON_PRETTY_PRINT);
    }

    final public static function status201(array $results): void
    {
        self::$httpResponse['status'] = 201;
        self::$httpResponse['results'] = $results;


        http_response_code(201);
        echo json_encode(self::$httpResponse, JSON_PRETTY_PRINT);
    }

    final public static function status400(array $results): void
    {
        self::$httpResponse['status'] = 200;
        self::$httpResponse['results'] = $results;


        http_response_code(400);
        echo json_encode(self::$httpResponse, JSON_PRETTY_PRINT);
    }

    final public static function status401(array $results): void
    {
        self::$httpResponse['status'] = 401;
        self::$httpResponse['results'] = $results;


        http_response_code(401);
        echo json_encode(self::$httpResponse, JSON_PRETTY_PRINT);
    }

    final public static function status404(array $results): void
    {
        self::$httpResponse['status'] = 404;
        self::$httpResponse['results'] = $results;


        http_response_code(404);
        echo json_encode(self::$httpResponse, JSON_PRETTY_PRINT);
    }

    final public static function status500(array $results): void
    {
        self::$httpResponse['status'] = 500;
        self::$httpResponse['results'] = $results;

        http_response_code(500);
        echo json_encode(self::$httpResponse, JSON_PRETTY_PRINT);
    }
}
