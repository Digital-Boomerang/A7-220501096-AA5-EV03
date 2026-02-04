<?php

require_once __DIR__ . '/../models/Cita.php';
require_once __DIR__ . '/../../core/Response.php';

/**
 * Servicio de gestión de citas
 *
 * Contiene la lógica de negocio relacionada con la creación,
 * listado, búsqueda, eliminación y consultas de horarios ocupados.
 */
class CitaService
{
    /**
     * Crear una nueva cita
     *
     * Valida que el usuario no tenga ya una cita en la misma fecha y horario.
     *
     * @param array $data Datos de la cita: id_usuario, fecha, id_horario, id_vehiculo, estado
     */
    public static function crear(array $data): void
    {
        try {
            // Verificar si el usuario ya tiene una cita en esa fecha y horario
            if (Cita::existe($data['id_usuario'], $data['fecha'], $data['id_horario'])) {
                Response::error(
                    "El usuario ya tiene una cita para esa fecha y horario",
                    400
                );
            }

            // Crear la cita
            $id = Cita::crear($data);

            // Responder con el ID de la cita creada
            Response::json([
                "mensaje" => "Cita creada",
                "id"      => $id
            ], 201);
        } catch (PDOException $e) {
            Response::error("No se pudo crear la cita. Intente de nuevo.", 409);
        } catch (Exception $e) {
            Response::error($e->getMessage(), 400);
        }
    }

    /**
     * Actualizar una cita por ID
     *
     * @param int $id ID de la cita
     * @param array $data Datos de la cita: fecha, estado, id_usuario, id_vehiculo, id_horario
     */
    public static function actualizar(int $id, array $data): void
    {
        $cita = Cita::buscarPorId($id);
        if (!$cita) {
            Response::error("Cita no encontrada", 404);
        }

        if (
            empty($data['fecha']) ||
            empty($data['estado']) ||
            empty($data['id_usuario']) ||
            empty($data['id_vehiculo']) ||
            empty($data['id_horario'])
        ) {
            Response::error("Debe indicar fecha, estado, usuario, vehiculo y horario", 400);
        }

        try {
            Cita::actualizar($id, $data);
            $actualizada = Cita::buscarPorId($id);
            Response::success("Cita actualizada", $actualizada);
        } catch (Exception $e) {
            Response::error($e->getMessage(), 400);
        }
    }

    /**
     * Listar todas las citas
     */
    public static function listar(): void
    {
        Response::json(Cita::listar());
    }

    /**
     * Buscar una cita por su ID
     *
     * @param int $id ID de la cita
     */
    public static function buscarPorId(int $id): void
    {
        $cita = Cita::buscarPorId($id);

        if (!$cita) {
            Response::error("Cita no encontrada", 404);
        }

        Response::json($cita);
    }

    /**
     * Eliminar una cita por su ID
     *
     * @param int $id ID de la cita
     */
    public static function eliminar(int $id): void
    {
        if (!Cita::eliminar($id)) {
            Response::error(
                "No se puede eliminar: cita no encontrada",
                404
            );
        }

        Response::success("Cita eliminada");
    }

    /**
     * Obtener horas ocupadas para una fecha específica
     *
     * @param string $fecha Fecha en formato YYYY-MM-DD
     */
    public static function horasOcupadas(string $fecha): void
    {
        Response::json(Cita::horasOcupadas($fecha));
    }
}
