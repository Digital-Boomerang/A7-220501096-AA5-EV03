<?php

require_once __DIR__ . '/../../config/database.php';

class Cita
{
    public static function listar()
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

    public static function buscar($id)
    {
        $db = Database::connect();

        $stmt = $db->prepare(
            "SELECT * FROM cita WHERE id_cita = ?"
        );

        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function crear($data)
    {
        $db = Database::connect();

        try {
            $db->beginTransaction();

            $stmt = $db->prepare(
                "INSERT INTO cita (fecha, estado, id_usuario, id_vehiculo)
                 VALUES (?, ?, ?, ?)"
            );

            $stmt->execute([
                $data["fecha"],
                $data["estado"],
                $data["id_usuario"],
                $data["id_vehiculo"]
            ]);

            // Ocupar horario (lógica separada del SQL)
            Horario::ocupar($data["id_horario"]);

            $idCita = $db->lastInsertId();

            $db->commit();
            return $idCita;

        } catch (Exception $e) {
            $db->rollBack();
            throw $e;
        }
    }
}
