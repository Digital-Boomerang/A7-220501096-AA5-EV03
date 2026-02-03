<?php

require_once __DIR__ . '/../app/controllers/AuthController.php';
require_once __DIR__ . '/../app/controllers/UsuarioController.php';
require_once __DIR__ . '/../app/controllers/VehiculoController.php';
require_once __DIR__ . '/../app/controllers/CitaController.php';
require_once __DIR__ . '/../app/controllers/HorarioController.php';
require_once __DIR__ . '/../app/controllers/ComentarioController.php';
require_once __DIR__ . '/../app/controllers/RolController.php';
require_once __DIR__ . '/../app/controllers/ExportacionController.php';



$router = new Router();

/*
|-------------------------------------------------------------------------- 
| AUTH (Autenticación)
|-------------------------------------------------------------------------- 
| Rutas para iniciar sesión y obtener credenciales de usuario.
*/
$router->post('/auth/login', [AuthController::class, 'login']);
$router->post('/api/auth/login', [AuthController::class, 'login']);

/*
|-------------------------------------------------------------------------- 
| USUARIOS
|-------------------------------------------------------------------------- 
| CRUD de usuarios: listar, obtener por ID, crear, actualizar y eliminar.
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
| CRUD de vehículos y listado de vehículos asociados a un usuario.
*/
$router->get('/api/vehiculos', [VehiculoController::class, 'listar']);
$router->get('/api/vehiculos/{id}', [VehiculoController::class, 'obtener']);
$router->post('/api/vehiculos', [VehiculoController::class, 'crear']);
$router->put('/api/vehiculos/{id}', [VehiculoController::class, 'actualizar']);
$router->delete('/api/vehiculos/{id}', [VehiculoController::class, 'eliminar']);

// Listar vehículos de un usuario específico
$router->get('/api/usuarios/{id}/vehiculos', [VehiculoController::class, 'listarPorUsuario']);

/*
|-------------------------------------------------------------------------- 
| CITAS
|-------------------------------------------------------------------------- 
| Rutas para gestión de citas: listar, obtener, crear, actualizar, eliminar
| y obtener horas ocupadas de un día específico.
*/
$router->get('/api/citas/horas-ocupadas', [CitaController::class, 'horasOcupadas']);
$router->get('/api/citas', [CitaController::class, 'listar']);
$router->get('/api/citas/{id}', [CitaController::class, 'obtener']);
$router->post('/api/citas', [CitaController::class, 'crear']);
$router->put('/api/citas/{id}', [CitaController::class, 'actualizar']);
$router->delete('/api/citas/{id}', [CitaController::class, 'eliminar']);

/*
|-------------------------------------------------------------------------- 
| HORARIOS
|-------------------------------------------------------------------------- 
| Rutas para gestión de horarios: listar todos, obtener por ID, crear,
| actualizar y eliminar horarios.
*/
$router->get('/api/horarios', [HorarioController::class, 'listar']);
$router->get('/api/horarios/{id}', [HorarioController::class, 'obtener']);
$router->post('/api/horarios', [HorarioController::class, 'crear']);
$router->put('/api/horarios/{id}', [HorarioController::class, 'actualizar']);
$router->delete('/api/horarios/{id}', [HorarioController::class, 'eliminar']);

/*
|-------------------------------------------------------------------------- 
| COMENTARIOS
|-------------------------------------------------------------------------- 
| Rutas para listar y crear comentarios de usuarios.
*/
$router->get('/api/comentarios', [ComentarioController::class, 'listar']);
$router->post('/api/comentarios', [ComentarioController::class, 'crear']);

/*
|-------------------------------------------------------------------------- 
| ROLES
|-------------------------------------------------------------------------- 
| Listado de roles disponibles en el sistema.
*/
$router->get('/api/roles', [RolController::class, 'listar']);

/*
|-------------------------------------------------------------------------- 
| EXPORTACIONES
|-------------------------------------------------------------------------- 
| Registrar exportaciones generadas por el sistema.
*/
$router->post('/api/exportaciones', [ExportacionController::class, 'registrar']);


