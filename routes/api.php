<?php

require_once __DIR__ . '/../app/controllers/AuthController.php';
require_once __DIR__ . '/../app/controllers/UsuarioController.php';
require_once __DIR__ . '/../app/controllers/VehiculoController.php';
require_once __DIR__ . '/../app/controllers/CitaController.php';
require_once __DIR__ . '/../app/controllers/HorarioController.php';

$router = new Router();

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
$router->post('/api/auth/login', [AuthController::class, 'login']);

/*
|--------------------------------------------------------------------------
| USUARIOS
|--------------------------------------------------------------------------
*/
$router->get('/api/usuarios', [UsuarioController::class, 'listar']);
$router->get('/api/usuarios/{id}', [UsuarioController::class, 'obtener']);
$router->post('/api/usuarios', [UsuarioController::class, 'crear']);
$router->put('/api/usuarios/{id}', [UsuarioController::class, 'actualizar']);
$router->delete('/api/usuarios/{id}', [UsuarioController::class, 'eliminar']);

/*
|--------------------------------------------------------------------------
| VEHÍCULOS
|--------------------------------------------------------------------------
*/
$router->get('/api/vehiculos', [VehiculoController::class, 'listar']);
$router->get('/api/vehiculos/{id}', [VehiculoController::class, 'obtener']);
$router->post('/api/vehiculos', [VehiculoController::class, 'crear']);
$router->put('/api/vehiculos/{id}', [VehiculoController::class, 'actualizar']);
$router->delete('/api/vehiculos/{id}', [VehiculoController::class, 'eliminar']);

/*
|--------------------------------------------------------------------------
| CITAS
|--------------------------------------------------------------------------
*/
$router->get('/api/citas', [CitaController::class, 'listar']);
$router->get('/api/citas/{id}', [CitaController::class, 'obtener']);
$router->post('/api/citas', [CitaController::class, 'crear']);
$router->put('/api/citas/{id}', [CitaController::class, 'actualizar']);
$router->delete('/api/citas/{id}', [CitaController::class, 'eliminar']);

/*
|--------------------------------------------------------------------------
| HORARIOS
|--------------------------------------------------------------------------
*/
$router->get('/api/horarios', [HorarioController::class, 'listar']);
$router->get('/api/horarios/{id}', [HorarioController::class, 'obtener']);
$router->post('/api/horarios', [HorarioController::class, 'crear']);
$router->put('/api/horarios/{id}', [HorarioController::class, 'actualizar']);
$router->delete('/api/horarios/{id}', [HorarioController::class, 'eliminar']);
