<?php

require_once __DIR__ . '/../services/VehiculoService.php';

/**
 * Controlador de Vehículos
 *
 * Gestiona las solicitudes HTTP relacionadas con vehículos,
 * delegando la lógica de negocio al servicio correspondiente.
 */
class VehiculoController
{
    /**
     * Listar todos los vehículos
     *
     * Llama al servicio para obtener todos los vehículos registrados
     * y envía la respuesta al cliente.
     */
    public function listar(): void
    {
        VehiculoService::listar();
    }

    /**
     * Obtener un vehículo por ID
     *
     * @param int $id ID del vehículo a consultar
     * Llama al servicio para buscar el vehículo y envía la respuesta.
     */
    public function obtener(int $id): void
    {
        VehiculoService::obtener($id);
    }

    /**
     * Crear un nuevo vehículo
     *
     * Lee los datos desde el cuerpo JSON de la solicitud y
     * delega la creación al servicio correspondiente.
     */
    public function crear(): void
    {
        $data = json_decode(file_get_contents("php://input"), true);
        VehiculoService::crear($data);
    }

    /**
     * Listar vehículos de un usuario específico
     *
     * @param int $idUsuario ID del usuario cuyos vehículos se desean listar
     * Llama al servicio para obtener los vehículos asociados al usuario.
     */
    public function listarPorUsuario(int $idUsuario): void
    {
        VehiculoService::listarPorUsuario($idUsuario);
    }
}
