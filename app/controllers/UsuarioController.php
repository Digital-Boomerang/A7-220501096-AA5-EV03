<?php

require_once __DIR__ . '/../services/UsuarioService.php';

/**
 * Controlador de Usuarios
 *
 * Gestiona las solicitudes HTTP relacionadas con los usuarios,
 * delegando la lógica de negocio al servicio correspondiente.
 */
class UsuarioController
{
    /**
     * Listar todos los usuarios
     *
     * Llama al servicio para obtener la lista completa de usuarios
     * y envía la respuesta al cliente.
     */
    public function listar(): void
    {
        UsuarioService::listar();
    }

    /**
     * Obtener un usuario por ID
     *
     * @param int $id ID del usuario a consultar
     * Llama al servicio para buscar el usuario y envía la respuesta.
     */
    public function obtener(int $id): void
    {
        UsuarioService::obtener($id);
    }

    /**
     * Crear un nuevo usuario
     *
     * Lee los datos desde el cuerpo JSON de la solicitud y
     * delega la creación al servicio correspondiente.
     */
    public function crear(): void
    {
        $data = json_decode(file_get_contents("php://input"), true);
        UsuarioService::crearUsuario($data);
    }

    /**
     * Eliminar un usuario por ID
     *
     * @param int $id ID del usuario a eliminar
     * Llama al servicio para eliminar el usuario y envía la respuesta.
     */
    public function eliminar(int $id): void
    {
        UsuarioService::eliminar($id);
    }
}
