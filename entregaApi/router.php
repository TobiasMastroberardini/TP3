<?php
require_once 'libs/router.php';
require_once './app/controller/auth.controller.php';
require_once './app/controller/page.controller.php';
require_once './app/controller/subscripciones.controller.php';

$router = new router();


$router->addRoute('sub', 'GET', 'subscripcionesController', 'ShowSubs');
$router->addRoute('sub/:ID', 'GET', 'subscripcionesController', 'ShowSubs');


$router->route($_GET["resource"], $_SERVER['REQUEST_METHOD']);

