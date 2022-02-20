<?php


require 'vendor/autoload.php';

use App\Router\Router;

$url = '';
if (isset($_GET['url'])) {
    $url = $_GET['url'];
}

$router = new Router($url);

$router->get('/', 'Exemple#index');
$router->get('/show', 'Exemple#show');
$router->get('/show/:id', 'Exemple#get');
$router->post('/update/:id', 'Exemple#update');


$router->get('/redirect', 'Exemple#testRedi');

$router->get('/toto', 'Exemple#toto');


$router->run();
