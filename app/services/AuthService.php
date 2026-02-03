<?php

require_once __DIR__ . '/../models/Credencial.php';
require_once __DIR__ . '/../../core/Response.php';

/**
 * Servicio de autenticación
 *
 * Encapsula la lógica de login de administradores.
 */
class AuthService
{
    /**
     * Login de administrador
     *
     * @param string $correo Correo del usuario
     * @param string $password Contraseña en texto plano
     */
    public static function login(string $correo, string $password): void
    {
        // 1. Buscar usuario + credencial en base al correo
        $data = Credencial::buscarPorCorreo($correo);

        // 1a. Si no existe, retornar error de autenticación
        if (!$data) {
            Response::error("Credenciales inválidas", 401);
        }

        // 2. Validar que sea administrador (rol ID = 1)
        if ((int)$data['id_rol'] !== 1) {
            Response::error("Solo administradores pueden iniciar sesión", 403);
        }

        // 3. Validar la contraseña usando password_verify()
        if (!password_verify($password, $data['contrasena'])) {
            Response::error("Credenciales inválidas", 401);
        }

        // 4. Responder con información del usuario, sin incluir contraseña
        Response::json([
            'id'     => $data['id_usuario'],
            'nombre' => $data['nombre'],
            'correo' => $data['correo'],
            'rol'    => $data['nombre_rol']
        ]);
    }
}
