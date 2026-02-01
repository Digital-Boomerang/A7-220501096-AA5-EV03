<?php

require_once __DIR__ . '/../../config/database.php';

class Horario
{
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
}
