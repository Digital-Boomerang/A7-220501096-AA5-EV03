<?php
require_once __DIR__ . '/../../config/database.php';

class Usuario {

    public static function listar() {
        $db = Database::connect();

        $sql = "SELECT id_usuario, nombre, correo, telefono, id_rol
                FROM usuario";

        return $db->query($sql)->fetchAll();
    }

    public static function buscar($id) {
        $db = Database::connect();

        $stmt = $db->prepare(
            "SELECT id_usuario, nombre, correo, telefono, id_rol
             FROM usuario WHERE id_usuario = ?"
        );

        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public static function crear($data) {
        $db = Database::connect();

        $stmt = $db->prepare(
            "INSERT INTO usuario (nombre, correo, telefono, id_rol)
             VALUES (?, ?, ?, ?)"
        );

        $stmt->execute([
            $data["nombre"],
            $data["correo"],
            $data["telefono"],
            $data["id_rol"]
        ]);

        return $db->lastInsertId();
    }
}
