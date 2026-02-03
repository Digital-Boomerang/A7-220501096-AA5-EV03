<?php

require_once __DIR__ . '/../models/Horario.php';
require_once __DIR__ . '/../../core/Response.php';

/**
 * Servicio para la gestión de horarios
 *
 * Contiene la lógica de negocio para crear, listar,
 * consultar y actualizar horarios en el sistema.
 */
class HorarioService
{
    /**
     * Crear un nuevo horario
     *
     * Valida que los campos obligatorios estén presentes
     * y luego crea el registro en la base de datos.
     *
     * @param array $data ['hora' => string, 'estado' => int]
     */
    public static function crear(array $data): void
    {
        // Validar que se envíe hora y estado
        if (empty($data['hora']) || !isset($data['estado'])) {
            Response::error(
                'Hora y estado son obligatorios',
                400
            );
        }

        // Crear horario en el modelo
        $id = Horario::crear($data);

        // Responder con éxito y datos del horario creado
        Response::success(
            'Horario creado correctamente',
            [
                'id_horario' => $id,
                'hora'       => $data['hora'],
                'estado'     => $data['estado']
            ],
            201
        );
    }

    /**
     * Listar todos los horarios
     *
     * Recupera todos los horarios registrados y devuelve en JSON.
     */
    public static function listar(): void
    {
        $horarios = Horario::listar();

        Response::json($horarios);
    }

    /**
     * Obtener un horario por su ID
     *
     * @param int $id Identificador del horario
     */
    public static function obtener(int $id): void
    {
        $horario = Horario::buscar($id);

        if (!$horario) {
            Response::error('Horario no encontrado', 404);
        }

        Response::json($horario);
    }

    /**
     * Cambiar el estado de un horario
     *
     * Permite activar o desactivar un horario según el valor enviado.
     *
     * @param int $id Identificador del horario
     * @param int $estado Nuevo estado (ej. 0 = inactivo, 1 = activo)
     */
    public static function cambiarEstado(int $id, int $estado): void
    {
        if (!Horario::cambiarEstado($id, $estado)) {
            Response::error(
                'No se pudo actualizar el estado del horario',
                400
            );
        }

        Response::success(
            'Estado del horario actualizado correctamente'
        );
    }
}
