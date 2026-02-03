<?php

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/Horario.php';

/**
 * Modelo Cita
 *
 * Representa las citas de revisión técnico-mecánica y gestiona
 * operaciones de base de datos relacionadas con ellas.
 */
class Cita
{
    /**
     * Listar todas las citas
     *
     * Devuelve información completa de cada cita incluyendo:
     * - Fecha y estado
     * - Nombre del cliente
     * - Placa del vehículo
     *
     * @return array Lista de citas
     */
    public static function listar(): array
    {
        $db = Database::connect();

        $sql = "
            SELECT c.id_cita,
                   c.fecha,
                   c.estado,
                   u.nombre AS cliente,
                   v.placa
            FROM cita c
            JOIN usuario u ON u.id_usuario = c.id_usuario
            JOIN vehiculo v ON v.id_vehiculo = c.id_vehiculo
            ORDER BY c.fecha DESC
        ";

        return $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Buscar una cita por su ID
     *
     * @param int $id ID de la cita
     * @return array|null Datos de la cita o null si no existe
     */
    public static function buscarPorId(int $id): ?array
    {
        $db = Database::connect();

        $stmt = $db->prepare("SELECT * FROM cita WHERE id_cita = ?");
        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    /**
     * Verificar si una cita existe para un usuario, fecha y horario específicos
     *
     * @param int $idUsuario ID del usuario
     * @param string $fecha Fecha de la cita (YYYY-MM-DD)
     * @param int $idHorario ID del horario
     * @return bool True si ya existe una cita, false si no
     */
    public static function existe(int $idUsuario, string $fecha, int $idHorario): bool
    {
        $db = Database::connect();

        $stmt = $db->prepare("
            SELECT 1
            FROM cita
            WHERE id_usuario = ?
              AND fecha = ?
              AND id_horario = ?
            LIMIT 1
        ");

        $stmt->execute([$idUsuario, $fecha, $idHorario]);
        return (bool) $stmt->fetch();
    }

    /**
     * Crear una nueva cita
     *
     * @param array $data Datos de la cita:
     *  - fecha, estado, id_usuario, id_vehiculo, id_horario
     * @return int ID de la cita creada
     * @throws Exception Si ocurre un error en la transacción
     */
    public static function crear(array $data): int
    {
        $db = Database::connect();

        try {
            $db->beginTransaction();

            // Marcar horario como ocupado de forma atómica
            $updateHorario = $db->prepare("
                UPDATE horario
                SET estado = 1
                WHERE id_horario = ?
                  AND (estado IS NULL OR estado = 0)
            ");
            $updateHorario->execute([$data["id_horario"]]);

            if ($updateHorario->rowCount() === 0) {
                // Verificar si el horario existe para diferenciar error
                $check = $db->prepare("
                    SELECT 1
                    FROM horario
                    WHERE id_horario = ?
                    LIMIT 1
                ");
                $check->execute([$data["id_horario"]]);
                if ($check->fetchColumn()) {
                    throw new Exception("Horario ocupado");
                }

                throw new Exception("Horario no encontrado");
            }

            // Insertar cita
            $stmt = $db->prepare("
                INSERT INTO cita (fecha, estado, id_usuario, id_vehiculo, id_horario)
                VALUES (?, ?, ?, ?, ?)
            ");

            $stmt->execute([
                $data["fecha"],
                $data["estado"],
                $data["id_usuario"],
                $data["id_vehiculo"],
                $data["id_horario"]
            ]);

            $id = $db->lastInsertId();
            $db->commit();

            return $id;

        } catch (Exception $e) {
            $db->rollBack();
            throw $e;
        }
    }

    /**
     * Eliminar una cita
     *
     * @param int $id ID de la cita
     * @return bool True si se eliminó, false si no existía
     */
    public static function eliminar(int $id): bool
    {
        $db = Database::connect();

        $stmt = $db->prepare("DELETE FROM cita WHERE id_cita = ?");
        $stmt->execute([$id]);

        return $stmt->rowCount() > 0;
    }

    /**
     * Obtener horarios ocupados en una fecha específica
     *
     * @param string $fecha Fecha de consulta (YYYY-MM-DD)
     * @return array Lista de horas ocupadas en formato HH:MM
     */
    public static function horasOcupadas(string $fecha): array
    {
        $db = Database::connect();

        $stmt = $db->prepare("
            SELECT h.hora
            FROM cita c
            JOIN horario h ON h.id_horario = c.id_horario
            WHERE c.fecha = ?
        ");

        $stmt->execute([$fecha]);

        // Devolver solo las horas en formato HH:MM
        return array_map(
            fn($r) => substr($r['hora'], 0, 5),
            $stmt->fetchAll(PDO::FETCH_ASSOC)
        );
    }
}
