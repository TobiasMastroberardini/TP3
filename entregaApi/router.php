<?php
require_once 'libs/router.php';
require_once './app/controller/auth.controller.php';
require_once './app/controller/page.controller.php';
require_once './app/controller/subscripciones.controller.php';

$router = new router();


$router->addRoute('sub', 'GET', 'subscripcionesController', 'ShowSubs');
$router->addRoute('sub/:ID', 'GET', 'subscripcionesController', 'ShowSubs');
$router->addRoute('sub/:ID', 'DELETE', 'subscripcionesController', 'deleteSubs'); 
$router->addRoute('sub', 'POST', 'subscripcionesController', 'addSubs'); //no
$router->addRoute('sub/:ID', 'PUT', 'subscripcionesController', 'updateSubs'); //no

$router->addRoute('socios', 'GET', 'pageController', 'ShowSocios');
$router->addRoute('socios/:ID', 'GET', 'pageController', 'ShowSocios'); 
$router->addRoute('socios/:ID', 'DELETE', 'pageController', 'deleteSocios'); 
$router->addRoute('socios', 'POST', 'pageController', 'addSocios'); //no
$router->addRoute('socios/:ID', 'PUT', 'pageController', 'updateSocio'); //no


$router->route($_GET["resource"], $_SERVER['REQUEST_METHOD']);

