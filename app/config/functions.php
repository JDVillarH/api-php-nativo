<?php

/**
 * Obtiene el host del sitio web con el esquema (http o https).
 * @return string El host del sitio web con el esquema (http o https).
 */
function getHost(): string
{
    return (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $_SERVER['HTTP_HOST'];
}

/**
 * Obtiene la ruta del directorio actual (Sin incluir el nombre del archivo).
 * @return string La ruta del directorio en el servidor.
 */
function getDirectoryPath(): string
{
    return str_replace(basename($_SERVER['SCRIPT_NAME']), "", $_SERVER['SCRIPT_NAME']);
}

/**
 * Obtiene la URL base completa del sitio web.
 * @return string La URL base del sitio web.
 */
function getBaseURL(): string
{
    return getHost() . getDirectoryPath();
}


/**
 * Obtiene la URL completa de la página actual.
 * @return string La URL completa de la página actual.
 */
function getCurrentURL($removeQueryParams = false): string
{
    $currentURI = $_SERVER['REQUEST_URI'];
    if ($removeQueryParams) {
        $currentURI = strstr($currentURI, '?') ? substr($currentURI, 0, strpos($currentURI, '?')) : $currentURI;
    }
    return getBaseURL() . str_replace(getDirectoryPath(), "", $currentURI);
}

/**
 * Obtiene un parámetro de la URL y lo convierte a un entero.
 * @param string $paramName El nombre del parámetro de la URL.
 * @param int $defaultValue El valor por defecto del parámetro.
 * @return int El valor del parámetro de la URL o el valor por defecto.
 */
function getIntegerParam(string $paramName, int $defaultValue = 0): int
{
    $param = filter_input(INPUT_GET, $paramName, FILTER_VALIDATE_INT) ?? $defaultValue;
    return $param > 0 ? $param : $defaultValue;
}
