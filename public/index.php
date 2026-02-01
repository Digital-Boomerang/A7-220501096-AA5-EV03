<?php

// ================================
// CONFIGURACIÓN BÁSICA
// ================================
date_default_timezone_set('America/Bogota');
header('Content-Type: application/json');

// ================================
// CORS
// ================================
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// ================================
// CORE
// ================================
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../core/Response.php';
require_once __DIR__ . '/../core/Router.php';

// ================================
// MODELOS
// ================================
require_once __DIR__ . '/../app/models/Usuario.php';
require_once __DIR__ . '/../app/models/Credencial.php';
require_once __DIR__ . '/../app/models/Vehiculo.php';
require_once __DIR__ . '/../app/models/Cita.php';
require_once __DIR__ . '/../app/models/Horario.php';

// ================================
// CONTROLADORES
// ================================
require_once __DIR__ . '/../app/controllers/AuthController.php';
require_once __DIR__ . '/../app/controllers/UsuarioController.php';
require_once __DIR__ . '/../app/controllers/VehiculoController.php';
require_once __DIR__ . '/../app/controllers/CitaController.php';
require_once __DIR__ . '/../app/controllers/HorarioController.php';

// ================================
// ROUTER
// ================================
$router = new Router();
require_once __DIR__ . '/../routes/api.php';
$router->resolve();
