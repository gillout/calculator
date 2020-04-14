<?php

// Lancement du serveur : php -S localhost:800X -t public

use App\Controller\AppController;
use App\Model\Calculator;
use App\Model\CalculatorManager;

include dirname(__DIR__) . '/config/config.php';

session_start();

$calc = new Calculator();
$manager = new CalculatorManager($calc);
$controller = new AppController($manager);

// CAS 1 : un nombre est envoyé
if (array_key_exists('value', $_POST)) {
    $controller->accumulate($_POST['value']);
}
// CAS 2 : un opérateur est envoyé
elseif (array_key_exists('action', $_POST)) {
    $controller->action($_POST['action']);
}
// CAS PAR DEFAUT : affichage de la calculatrice
else {
    $controller->index();
}

