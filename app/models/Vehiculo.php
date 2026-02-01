<?php
require_once __DIR__ . '/../../config/database.php';

class Vehiculo {

    public static function listar() {
        $db = Database::connect();

        $sql = "SELECT v.*, u.nombre AS propietario
                FROM vehiculo v
                JOIN usuario u ON u.id_usuario = v.id_usuario";

        return $db->query($sql)->fetchAll();
    }

    public static function buscar($id) {
        $db = Database::connect();

        $stmt = $db->prepare(
            "SELECT * FROM vehiculo WHERE id_vehiculo = ?"
        );

        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public static function crear($data) {
        $db = Database::connect();

        $stmt = $db->prepare(
            "INSERT INTO vehiculo
             (placa, marca, modelo, cilindraje, id_usuario)
             VALUES (?, ?, ?, ?, ?)"
        );

        $stmt->execute([
            $data["placa"],
            $data["marca"],
            $data["modelo"],
            $data["cilindraje"],
            $data["id_usuario"]
        ]);

        return $db->lastInsertId();
    }
}
