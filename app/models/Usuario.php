<?php

require_once __DIR__ . '/../../config/database.php';

/**
 * Modelo Usuario
 *
 * Gestiona las operaciones de la entidad usuario.
 * Permite crear, listar, buscar y eliminar usuarios,
 * así como verificar la existencia por correo.
 */
class Usuario
{
    /**
     * Listar todos los usuarios
     *
     * @return array Arreglo asociativo con los datos de los usuarios
     *   - id_usuario
     *   - nombre
     *   - correo
     *   - telefono
     *   - id_rol
     */
    public static function listar(): array
    {
        $db = Database::connect();

        return $db->query("
            SELECT id_usuario, nombre, correo, telefono, id_rol
            FROM usuario
        ")->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Buscar un usuario por su ID
     *
     * @param int $id ID del usuario
     * @return array|false Arreglo con los datos del usuario o false si no existe
     */
    public static function buscar(int $id): array|false
    {
        $db = Database::connect();

        $stmt = $db->prepare("
            SELECT id_usuario, nombre, correo, telefono, id_rol
            FROM usuario
            WHERE id_usuario = ?
        ");

        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Buscar un usuario por ID (alias para compatibilidad)
     *
     * @param int $id ID del usuario
     * @return array|false Arreglo con los datos del usuario o false si no existe
     */
    public static function buscarPorId(int $id): array|false
    {
        return self::buscar($id);
    }

    /**
     * Crear un nuevo usuario
     *
     * @param array $data Datos del usuario:
     *   - nombre
     *   - correo
     *   - telefono
     *   - id_rol
     * @return int ID del usuario creado
     */
    public static function crear(array $data): int
    {
        $db = Database::connect();

        $stmt = $db->prepare("
            INSERT INTO usuario (nombre, correo, telefono, id_rol)
            VALUES (?, ?, ?, ?)
        ");

        $stmt->execute([
            $data['nombre'],
            $data['correo'],
            $data['telefono'],
            $data['id_rol']
        ]);

        return (int) $db->lastInsertId();
    }

    /**
     * Eliminar un usuario por su ID
     *
     * @param int $id ID del usuario
     * @return bool true si se eliminó correctamente, false si no existía
     */
    public static function eliminar(int $id): bool
    {
        $db = Database::connect();

        $stmt = $db->prepare("DELETE FROM usuario WHERE id_usuario = ?");
        $stmt->execute([$id]);

        return $stmt->rowCount() > 0;
    }

    /**
     * Actualizar un usuario por su ID
     *
     * @param int $id ID del usuario
     * @param array $data Datos del usuario:
     *   - nombre
     *   - correo
     *   - telefono
     *   - id_rol
     * @return bool true si se actualizó correctamente
     */
    public static function actualizar(int $id, array $data): bool
    {
        $db = Database::connect();

        $stmt = $db->prepare("
            UPDATE usuario
            SET nombre = ?, correo = ?, telefono = ?, id_rol = ?
            WHERE id_usuario = ?
        ");

        $stmt->execute([
            $data['nombre'],
            $data['correo'],
            $data['telefono'],
            $data['id_rol'],
            $id
        ]);

        return true;
    }

    /**
     * Verificar si un usuario existe por correo
     *
     * @param string $correo Correo electrónico a verificar
     * @return bool true si existe, false si no
     */
    public static function existsByCorreo(string $correo): bool
    {
        $db = Database::connect();

        $stmt = $db->prepare("SELECT 1 FROM usuario WHERE correo = ?");
        $stmt->execute([$correo]);

        return (bool) $stmt->fetchColumn();
    }

    /**
     * Verificar si un correo existe en otro usuario
     *
     * @param string $correo Correo electrónico a verificar
     * @param int $id ID del usuario actual
     * @return bool true si existe en otro usuario, false si no
     */
    public static function existsByCorreoExceptId(string $correo, int $id): bool
    {
        $db = Database::connect();

        $stmt = $db->prepare("
            SELECT 1 FROM usuario
            WHERE correo = ? AND id_usuario <> ?
        ");
        $stmt->execute([$correo, $id]);

        return (bool) $stmt->fetchColumn();
    }
}
