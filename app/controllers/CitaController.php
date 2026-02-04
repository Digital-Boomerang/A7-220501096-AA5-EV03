<?php

require_once __DIR__ . '/../services/CitaService.php';

/**
 * Controlador de Citas
 * --------------------------------------------------
 * Gestiona las solicitudes HTTP relacionadas con
 * la entidad Cita.
 *
 * Responsabilidades:
 * - Recibir y validar parámetros de entrada
 * - Delegar la lógica de negocio al servicio
 * - Retornar respuestas estructuradas al cliente
 */
class CitaController
{
    /**
     * Listar todas las citas
     *
     * Endpoint:
     * - GET /api/citas
     *
     * Retorna el listado completo de citas registradas.
     */
    public static function listar(): void
    {
        CitaService::listar();
    }

    /**
     * Obtener una cita por ID
     *
     * Endpoint:
     * - GET /api/citas/{id}
     *
     * Parámetros:
     * - id (int): identificador de la cita
     */
    public static function obtener(int $id): void
    {
        // Delegar la búsqueda al servicio
        CitaService::buscarPorId($id);
    }

    /**
     * Crear una nueva cita
     *
     * Endpoint:
     * - POST /api/citas
     *
     * Entrada esperada (JSON):
     * {
     *   "fecha": "YYYY-MM-DD",
     *   "estado": "pendiente",
     *   "id_usuario": 1,
     *   "id_vehiculo": 2,
     *   "id_horario": 5
     * }
     */
    public static function crear(): void
    {
        // Leer el cuerpo de la petición (JSON)
        $data = json_decode(
            file_get_contents("php://input"),
            true
        );

        // Delegar la creación al servicio
        CitaService::crear($data);
    }

    /**
     * Actualizar una cita por ID
     *
     * Endpoint:
     * - PUT /api/citas/{id}
     *
     * Entrada esperada (JSON):
     * {
     *   "fecha": "YYYY-MM-DD",
     *   "estado": "pendiente",
     *   "id_usuario": 1,
     *   "id_vehiculo": 2,
     *   "id_horario": 5
     * }
     */
    public static function actualizar(int $id): void
    {
        $data = json_decode(
            file_get_contents("php://input"),
            true
        );

        CitaService::actualizar($id, $data);
    }

    /**
     * Eliminar una cita por ID
     *
     * Endpoint:
     * - DELETE /api/citas/{id}
     */
    public static function eliminar(int $id): void
    {
        CitaService::eliminar($id);
    }

    /**
     * Obtener horas ocupadas para una fecha
     *
     * Endpoint:
     * - GET /api/citas/horas-ocupadas?fecha=YYYY-MM-DD
     */
    public static function horasOcupadas(): void
    {
        $fecha = $_GET['fecha'] ?? null;
        if (!$fecha) {
            Response::error("Fecha requerida", 400);
        }

        CitaService::horasOcupadas($fecha);
    }
}
