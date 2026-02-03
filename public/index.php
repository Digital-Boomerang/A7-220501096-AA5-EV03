<?php

// ================================
// CONFIGURACIÓN BÁSICA
// ================================
date_default_timezone_set('America/Bogota'); // Establece la zona horaria
header('Content-Type: application/json');    // Todas las respuestas serán JSON

// ================================
// CORS (Cross-Origin Resource Sharing)
// ================================
header('Access-Control-Allow-Origin: *'); // Permitir solicitudes desde cualquier dominio
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS'); // Métodos HTTP permitidos
header('Access-Control-Allow-Headers: Content-Type, Authorization'); // Encabezados permitidos

// Respuesta inmediata a solicitudes OPTIONS (preflight)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// ================================
// CORE DEL SISTEMA
// ================================
require_once __DIR__ . '/../config/database.php';  // Conexión a la base de datos
require_once __DIR__ . '/../core/Response.php';    // Clase para respuestas JSON
require_once __DIR__ . '/../core/Router.php';      // Sistema de enrutamiento

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
$router = new Router();                   // Instancia el enrutador
require_once __DIR__ . '/../routes/api.php'; // Carga las rutas definidas
$router->resolve();                        // Resuelve la ruta actual y llama al controlador
