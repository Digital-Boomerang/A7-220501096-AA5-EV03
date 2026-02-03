<?php

require_once __DIR__ . '/../../config/database.php';

/**
 * Modelo Rol
 *
 * Gestiona los roles de usuario dentro del sistema.
 * Cada rol tiene un ID y un nombre descriptivo.
 */
class Rol
{
    /**
     * Buscar un rol por ID
     *
     * @param int $id ID del rol
     * @return array|false Datos del rol o false si no existe
     */
    public static function findById(int $id): array|false
    {
        $db = Database::connect();

        $stmt = $db->prepare("
            SELECT id_rol AS id, nombre_rol AS nombre
            FROM rol
            WHERE id_rol = ?
            LIMIT 1
        ");

        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Listar todos los roles
     *
     * @return array Arreglo con los roles existentes
     *   - 'id': ID del rol
     *   - 'nombre': Nombre del rol
     */
    public static function listar(): array
    {
        $db = Database::connect();

        // Consulta para obtener todos los roles ordenados por nombre
        $stmt = $db->query("
            SELECT 
                id_rol AS id,
                nombre_rol AS nombre
            FROM rol
            ORDER BY nombre_rol
        ");

        return $stmt->fetchAll();
    }
}
