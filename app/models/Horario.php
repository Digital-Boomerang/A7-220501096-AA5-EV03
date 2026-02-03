<?php

require_once __DIR__ . '/../../config/database.php';

/**
 * Modelo Horario
 *
 * Gestiona los horarios disponibles para agendar citas.
 * Cada horario tiene una hora y un estado (libre/ocupado).
 */
class Horario
{
    /**
     * Listar todos los horarios
     *
     * @return array Arreglo con todos los horarios y su estado
     */
    public static function listar(): array
    {
        $db = Database::connect();

        $sql = "
            SELECT id_horario, hora, estado
            FROM horario
            ORDER BY hora
        ";

        $stmt = $db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Buscar un horario por su ID
     *
     * @param int $id ID del horario
     * @return array|false Arreglo con los datos del horario o false si no existe
     */
    public static function buscar(int $id): array|false
    {
        $db = Database::connect();

        $stmt = $db->prepare(
            "SELECT id_horario, hora, estado
             FROM horario
             WHERE id_horario = ?"
        );

        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Crear un nuevo horario
     *
     * @param array $data Datos del horario:
     *   - 'hora': Hora del horario (formato HH:MM:SS)
     *   - 'estado': Estado inicial (0 = libre, 1 = ocupado)
     * @return int ID del horario recién creado
     */
    public static function crear(array $data): int
    {
        $db = Database::connect();

        $stmt = $db->prepare(
            "INSERT INTO horario (hora, estado)
             VALUES (?, ?)"
        );

        $stmt->execute([
            $data['hora'],
            $data['estado']
        ]);

        return (int) $db->lastInsertId();
    }

    /**
     * Cambiar el estado de un horario
     *
     * @param int $idHorario ID del horario
     * @param int $estado Nuevo estado (0 = libre, 1 = ocupado)
     * @return bool True si la actualización fue exitosa, false en caso contrario
     */
    public static function cambiarEstado(int $idHorario, int $estado): bool
    {
        $db = Database::connect();

        $stmt = $db->prepare(
            "UPDATE horario
             SET estado = ?
             WHERE id_horario = ?"
        );

        return $stmt->execute([$estado, $idHorario]);
    }

    /**
     * Marcar un horario como ocupado
     *
     * @param int $idHorario ID del horario
     * @return bool True si se actualizó, false si falló
     */
    public static function ocupar(int $idHorario): bool
    {
        return self::cambiarEstado($idHorario, 1);
    }
}
