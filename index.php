<?php
require 'start.php';
require('Configuracion/JWT/Middleware.php');

use Controllers\UsuarioController;
use Controllers\RestaurantesController;
use Controllers\ComidaController;
use Controllers\PreciosController;
use Middleware\MiddlewareJwt;

$data = json_decode(file_get_contents('php://input'), true);
if (!isset($data)) {
    $data = $_POST;
}

$router = new Router\Router('/servicios');
$router->post('/nuevoUsuario', function () use ($data) {
    call_user_func([UsuarioController::class, 'crearUsuario'], $data);
});
$router->post('/login', function () use ($data) {
    call_user_func([UsuarioController::class, 'login'], $data);
});
$router->post('/nuevorRestaurante', function () use ($data) {
    call_user_func([RestaurantesController::class, 'crearRestaurante'], $data);
});
$router->get('/restaurantesdatos',[RestaurantesController::class,'datos']);

$router->post('/nuevacomida', function () use ($data) {
    call_user_func([ComidaController::class, 'crearComida'], $data);
});
$router->get('/comidas',[ComidaController::class,'comidas']);
$router->post('/nuevoprecio', function () use ($data) {
    call_user_func([PreciosController::class, 'Nuevoprecio'], $data);
});
$router->get('/precios',[PreciosController::class,'Precios']);

$router->add('/.*', function () {
    header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
    echo '<h1>404 - El sitio solicitado no existe</h1>';
});
$router->route();
?>