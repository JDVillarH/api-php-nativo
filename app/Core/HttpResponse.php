<?php

namespace App\Core;

class HttpResponse
{
    final public static function httpResponse(string $method)
    {
        header('Content-Type: application/json');
        $httpOrigin = $_SERVER['HTTP_ORIGIN'] ?? "*";

        if (in_array($httpOrigin, ALLOWED_DOMAINS) || APP_LOCAL == "true") {
            header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Authorization");
            header('Access-Control-Allow-Methods: GET, PUT, POST, OPTIONS, PATCH, DELETE, HEAD');
            header("Access-Control-Allow-Origin: $httpOrigin");

            if ($method !== "OPTIONS") {
                header("Allow: GET, POST, OPTIONS, PUT, PATCH , DELETE, HEAD");
            }
        } else {
            die(self::status401(["message" => "No tiene permisos para consumir este recurso"]));
        }
    }

    final public static function status200(array $results, array $pagination = null): void
    {
        http_response_code(200);
        if (!is_null($pagination)) {
            echo json_encode(["status" => 200, "pagination" => $pagination, "results" => $results], JSON_PRETTY_PRINT);
        } else {
            echo json_encode(["status" => 200, "results" => $results], JSON_PRETTY_PRINT);
        }
    }

    final public static function status201(array $results): void
    {
        http_response_code(201);
        echo json_encode(["status" => 201, "results" => $results], JSON_PRETTY_PRINT);
    }

    final public static function status204(): void
    {
        http_response_code(204);
    }

    final public static function status400(array $results): void
    {
        http_response_code(400);
        echo json_encode(["status" => 400, "results" => $results], JSON_PRETTY_PRINT);
    }

    final public static function status401(array $results): void
    {
        http_response_code(401);
        echo json_encode(["status" => 401, "results" => $results], JSON_PRETTY_PRINT);
    }

    final public static function status404(array $results): void
    {
        http_response_code(404);
        echo json_encode(["status" => 404, "results" => $results], JSON_PRETTY_PRINT);
    }

    final public static function status500(array $results): void
    {
        http_response_code(500);
        echo json_encode(["status" => 500, "results" => $results], JSON_PRETTY_PRINT);
    }
}
