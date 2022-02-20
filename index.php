<?php

use App\Models\TestModel;

require 'vendor/autoload.php';

use App\Router\Router;

$url = '';
if (isset($_GET['url'])) {
    $url = $_GET['url'];
}

$router = new Router($url);


$router->get('/', 'Portfolio#index');
$router->get('/formation', 'Portfolio#formation');
$router->get('/experiences', 'Portfolio#experiences');
$router->get('/competences', 'Portfolio#competences');
$router->get('/perspectives', 'Portfolio#perspectives');
$router->get('/centre_interet', 'Portfolio#centre_interet');
$router->get('/contact', 'Portfolio#contact');

$router->get('/test', 'Test#test');


$router->run();