<?php

require_once __DIR__ . '/../services/AuthService.php';

/**
 * Controlador de Autenticación
 * --------------------------------------------------
 * Maneja las solicitudes relacionadas con el inicio
 * de sesión de usuarios.
 *
 * Responsabilidades:
 * - Recibir credenciales desde el cliente
 * - Validar datos mínimos de entrada
 * - Delegar la autenticación al servicio correspondiente
 */
class AuthController
{
    /**
     * Iniciar sesión
     *
     * Endpoint encargado de autenticar un usuario
     * usando correo y contraseña.
     *
     * Método:
     * - POST
     *
     * Entrada esperada (JSON):
     * {
     *   "correo": "usuario@email.com",
     *   "contrasena": "password"
     * }
     */
    public static function login(): void
    {
        // Leer el cuerpo de la petición (JSON)
        $data = json_decode(
            file_get_contents("php://input"),
            true
        );

        // Aceptar "contrasena" o "password" para compatibilidad
        $password = $data['contrasena'] ?? $data['password'] ?? null;

        // Validar campos obligatorios
        if (
            empty($data['correo']) ||
            empty($password)
        ) {
            Response::error(
                "Correo y contraseña son obligatorios",
                400
            );
        }

        // Delegar la lógica de autenticación al servicio
        AuthService::login(
            $data['correo'],
            $password
        );
    }
}
