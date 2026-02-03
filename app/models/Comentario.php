<?php

require_once __DIR__ . '/../../config/database.php';

/**
 * Modelo Comentario
 *
 * Representa los comentarios que los usuarios pueden dejar
 * y gestiona las operaciones de base de datos asociadas.
 */
class Comentario {

    /**
     * Crear un nuevo comentario
     *
     * @param array $data Datos del comentario:
     *   - nombre: Nombre del autor
     *   - mensaje: Contenido del comentario
     *
     * @return array Datos del comentario recién creado, incluyendo ID y fecha
     */
    public static function crear(array $data) {

        $db = Database::connect();

        $stmt = $db->prepare("
            INSERT INTO comentario (nombre, mensaje, fecha_publicacion)
            VALUES (:nombre, :mensaje, :fecha)
        ");

        // Ejecutar la inserción con los valores recibidos
        $stmt->execute([
            ':nombre'  => $data['nombre'],
            ':mensaje' => $data['mensaje'],
            ':fecha'   => date('Y-m-d') // Fecha actual
        ]);

        // Retornar el registro insertado con ID generado
        return [
            "id" => $db->lastInsertId(),
            "nombre" => $data['nombre'],
            "mensaje" => $data['mensaje'],
            "fecha_publicacion" => date('Y-m-d')
        ];
    }

    /**
     * Listar todos los comentarios
     *
     * Los comentarios se ordenan por fecha de publicación descendente
     *
     * @return array Lista de comentarios
     */
    public static function listar() {

        $db = Database::connect();

        $stmt = $db->query("
            SELECT id_comentario AS id,
                   nombre,
                   mensaje,
                   fecha_publicacion
            FROM comentario
            ORDER BY fecha_publicacion DESC
        ");

        return $stmt->fetchAll();
    }
}
