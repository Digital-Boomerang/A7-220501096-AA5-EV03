<?php
require_once __DIR__ . '/../../config/database.php';

class Horario {

    public static function listar() {
        $db = Database::connect();

        $sql = "SELECT id_horario, fecha, hora, disponible
                FROM horario
                ORDER BY fecha, hora";

        return $db->query($sql)->fetchAll();
    }

    public static function buscar($id) {
        $db = Database::connect();

        $stmt = $db->prepare(
            "SELECT * FROM horario WHERE id_horario = ?"
        );

        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public static function crear($data) {
        $db = Database::connect();

        $stmt = $db->prepare(
            "INSERT INTO horario (fecha, hora, disponible)
             VALUES (?, ?, ?)"
        );

        $stmt->execute([
            $data["fecha"],
            $data["hora"],
            $data["disponible"]
        ]);

        return $db->lastInsertId();
    }

    public static function ocupar($idHorario) {
        $db = Database::connect();

        $stmt = $db->prepare(
            "UPDATE horario SET disponible = 0
             WHERE id_horario = ?"
        );

        $stmt->execute([$idHorario]);
    }
}
