<?php

namespace App\Core;

date_default_timezone_set("America/Santiago");

class ErrorLog
{
    public static function activateErrorLog(): void
    {
        error_reporting(E_ALL); // Mostrar todos los errores
        ini_set("ignore_repeated_errors", true); // No repetir errores
        ini_set("display_errors", false); // Mostrar errores en pantalla
        ini_set("log_error", true); // Guardar errores en un archivo
        ini_set("error_log", dirname(__DIR__) . "/Logs/php-error.log"); // Ruta del archivo de errores
    }
}
