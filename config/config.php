<?php

use App\Autoloader;

define('ROOT', dirname(__DIR__));

require_once ROOT . '/app/Autoloader.php';

Autoloader::register();
