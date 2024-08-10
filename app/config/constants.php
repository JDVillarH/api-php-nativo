<?php

use Dotenv\Dotenv;

$dotEnv = Dotenv::createImmutable(__DIR__ . '/../../');
$dotEnv->load();

define("APP_LOCAL", $_ENV['APP_LOCAL']);

define("DB_HOST", $_ENV['DB_HOST']);
define("DB_PORT", $_ENV['DB_PORT']);
define("DB_CHARSET", $_ENV['DB_CHARSET']);
define("DB_DATABASE", $_ENV['DB_DATABASE']);
define("DB_USERNAME", $_ENV['DB_USERNAME']);
define("DB_PASSWORD", $_ENV['DB_PASSWORD']);

// Dominios permitidos para consumir la API
define("ALLOWED_DOMAINS", []);
