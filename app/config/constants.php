<?php

use Dotenv\Dotenv;

$dotEnv = Dotenv::createImmutable(__DIR__ . '/../../');
$dotEnv->load();

define("APP_NAME", $_ENV['APP_NAME']);
define("APP_KEY", $_ENV['APP_KEY']);
define("APP_ENV", $_ENV['APP_ENV']);

define("DB_HOST", $_ENV['DB_HOST']);
define("DB_PORT", $_ENV['DB_PORT']);
define("DB_DATABASE", $_ENV['DB_DATABASE']);
define("DB_USERNAME", $_ENV['DB_USERNAME']);
define("DB_PASSWORD", $_ENV['DB_PASSWORD']);
