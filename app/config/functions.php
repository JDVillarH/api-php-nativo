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
    $baseURL = getBaseURL();
    $directoryPath = getDirectoryPath();

    if ($removeQueryParams) {
        $currentURI = explode('?', $currentURI)[0];
    }

    return rtrim($baseURL, '/') . ($directoryPath === "/" ? $currentURI : str_replace($directoryPath, "", $currentURI));
}
