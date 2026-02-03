<?php

require_once __DIR__ . '/../models/Rol.php';
require_once __DIR__ . '/../../core/Response.php';

/**
 * Servicio para la gestión de roles
 *
 * Contiene la lógica de negocio para listar los roles disponibles
 * en el sistema.
 */
class RolService
{
    /**
     * Listar todos los roles
     *
     * Recupera todos los roles de la base de datos
     * y devuelve la información en formato JSON.
     */
    public static function listar(): void
    {
        // Obtener roles desde el modelo
        $roles = Rol::listar();

        // Responder con los roles obtenidos
        Response::json($roles);
    }
}
