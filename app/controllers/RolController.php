<?php

/**
 * Controlador de Roles
 *
 * Gestiona las solicitudes HTTP relacionadas con los roles de usuario,
 * delegando la lógica de negocio al servicio correspondiente.
 */
require_once __DIR__ . '/../services/RolService.php';

class RolController
{
    /**
     * Listar todos los roles
     *
     * Llama al servicio para obtener la lista completa de roles
     * y envía la respuesta al cliente.
     */
    public function listar(): void
    {
        RolService::listar();
    }
}
