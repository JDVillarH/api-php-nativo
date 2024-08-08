<?php

namespace App\Core;

use mysqli;

class Model
{
    protected $connection;
    protected $queryResult;

    public function __construct()
    {
        $this->connection = $this->connect();
    }

    public function __destruct()
    {
        $this->connection->close();
    }

    /**
     * Conexión a la base de datos
     * 
     * @return mysqli Retorna la conexión a la base de datos o muestra un error
     */
    private function connect()
    {
        $this->connection = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
        $this->connection->set_charset("utf8mb4");

        if ($this->connection->connect_error) {
            error_log("Error al conectar con la base de datos: {$this->connection->connect_error})");
            die(HttpResponse::status500(["message" => "Ha ocurrido un error en el servidor"]));
        }

        return $this->connection;
    }

    /**
     * Escapar una cadena de caracteres
     * 
     * @param string $string Cadena de caracteres a escapar
     * @return string Cadena de caracteres escapadas
     */
    public final function escapeString(string $string): string
    {
        return $this->connection->real_escape_string($string);
    }

    /**
     * Ejecuta una consulta personalizada
     * 
     * @param string $query Consulta a ejecutar
     * @param int $perPage Cantidad de filas por página
     * 
     * @return Model Retorna el resultado de la consulta
     */
    public final function customSingleQuery(string $sqlQuery, int $perPage = null): Model
    {
        if (!is_null($perPage)) {
            $offset = max(0, (getIntegerParam("page", 1) - 1) * $perPage);
            $this->queryResult = $this->connection->query($sqlQuery . " LIMIT $perPage OFFSET $offset");
        } else {
            $this->queryResult = $this->connection->query($sqlQuery);
        }

        return $this;
    }

    public final function pagination(int $perPage, int $pageParam, int $totalRows): array
    {
        $totalPages = ceil($totalRows / $perPage);
        $currentURL = getCurrentURL();

        if (strpos($currentURL, "page=$pageParam") === false) {
            $querySeparator = (strpos($currentURL, "?") === false) ? "?" : "&";
            $currentURL .= $querySeparator . "page=$pageParam";
        }

        $nextPage = ($pageParam < $totalPages) ? str_replace("page=$pageParam", "page=" . ($pageParam + 1), $currentURL) : null;
        $previousPage = ($pageParam > 1) ? str_replace("page=$pageParam", "page=" . ($pageParam - 1), $currentURL) : null;

        return ["next" => $nextPage, "previous" => $previousPage];
    }


    /**
     * Devuelve el primer resultado de la consulta
     * 
     * @return object Retorna el primer resultado de la consulta o muestra un error
     */
    public final function first(): object
    {
        return $this->queryResult->fetch_object();
    }

    /**
     * Devuelve el resultado de la consulta
     * 
     * @return array Retorna el resultado de la consulta o muestra un error
     */
    public final function get(): array
    {
        return $this->queryResult->fetch_all(MYSQLI_ASSOC);
    }
}
