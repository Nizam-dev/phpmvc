<?php
require_once __DIR__  . '/app/config/__init.php';


$route = new Route();


$route->get("/",'HomeController->index');
$route->get("cek/{id}",'HomeController->view');