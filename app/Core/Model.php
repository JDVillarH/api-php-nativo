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
        $this->connection->set_charset(DB_CHARSET);

        if ($this->connection->connect_error) {
            error_log("Error al conectar con la base de datos: {$this->connection->connect_error})");
            die(HttpResponse::status500(["message" => "Ha ocurrido un error en el servidor"]));
        }

        return $this->connection;
    }

    /**
     * Ejecuta una consulta personalizada
     * 
     * @param string $query Consulta a ejecutar
     * @param int $page Página actual
     * @param int $limit Cantidad de filas por página
     * 
     * @return Model Retorna el resultado de la consulta
     */
    public final function customQuery(string $sqlQuery, int $page = null, int $limit = null): Model
    {
        if (!is_null($limit)) {
            $offset = max(0, ($page - 1) * $limit);
            $this->queryResult = $this->connection->query($sqlQuery . " LIMIT $limit OFFSET $offset");
        } else {
            $this->queryResult = $this->connection->query($sqlQuery);
        }

        return $this;
    }

    /**
     * Genera la paginación
     * 
     * @param string $sqlQuery Consulta SQL que devuelve la cantidad de filas
     * @param int $page Página actual
     * @param int $limit Cantidad de filas por página
     * 
     * @return array Paginación
     */
    public final function pagination(string $sqlQuery, int $page, int $limit): array
    {
        $totalRows = (int) $this->customQuery($sqlQuery)->first()->totalRows;
        $totalPages = ceil($totalRows / $limit);
        $currentURL = getCurrentURL();

        // Validar si existe la página
        if ($page > $totalPages) {
            die(HttpResponse::status404(["message" => "404 Not Found"]));
        }

        if (strpos($currentURL, "page=$page") === false) {
            $querySeparator = (strpos($currentURL, "?") === false) ? "?" : "&";
            $currentURL .= $querySeparator . "page=$page";
        }

        $nextPage = ($page < $totalPages) ? str_replace("page=$page", "page=" . ($page + 1), $currentURL) : null;
        $previousPage = ($page > 1) ? str_replace("page=$page", "page=" . ($page - 1), $currentURL) : null;

        return ["next" => $nextPage, "previous" => $previousPage, "total" => $totalRows];
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
