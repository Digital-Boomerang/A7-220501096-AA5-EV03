<?php

require_once __DIR__ . '/../../config/database.php';


class Credencial {

    public static function login($correo) {
        $db = Database::connect();

        $stmt = $db->prepare("
            SELECT c.id_credencial, c.contrasena, u.id_usuario, u.nombre, u.correo, r.nombre_rol
            FROM credencial c
            JOIN usuario u ON u.id_usuario = c.id_usuario
            JOIN rol r ON r.id_rol = u.id_rol
            WHERE u.correo = ?
        ");

        $stmt->execute([$correo]);
        return $stmt->fetch();
    }
}
