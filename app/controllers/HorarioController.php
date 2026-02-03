<?php

/**
 * Controlador de Horarios
 *
 * Se encarga de recibir las solicitudes HTTP relacionadas con los horarios,
 * validando datos básicos y delegando la lógica de negocio al servicio correspondiente.
 */
require_once __DIR__ . '/../services/HorarioService.php';

class HorarioController
{
    /**
     * Listar todos los horarios
     *
     * Llama al servicio para obtener todos los horarios registrados
     * y envía la respuesta al cliente.
     */
    public function listar(): void
    {
        HorarioService::listar();
    }

    /**
     * Crear un nuevo horario
     *
     * Recibe un JSON en el cuerpo de la petición, valida que sea un arreglo
     * y lo envía al servicio para su creación.
     */
    public function crear(): void
    {
        $data = json_decode(file_get_contents('php://input'), true);

        if (!is_array($data)) {
            Response::error('JSON inválido', 400);
        }

        HorarioService::crear($data);
    }

    /**
     * Obtener un horario específico
     *
     * Recibe el ID como parámetro de la ruta, lo convierte a entero
     * y solicita al servicio la información del horario correspondiente.
     *
     * @param int|string $id ID del horario a consultar
     */
    public function obtener($id): void
    {
        HorarioService::obtener((int) $id);
    }
}
