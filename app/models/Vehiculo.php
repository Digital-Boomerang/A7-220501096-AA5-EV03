<?php

require_once __DIR__ . '/../../config/database.php';

/**
 * Modelo Vehiculo
 *
 * Gestiona las operaciones de la entidad vehículo.
 * Permite crear, listar, buscar vehículos,
 * listar vehículos por usuario y verificar existencia por placa.
 */
class Vehiculo
{
    /**
     * Listar todos los vehículos
     *
     * @return array Arreglo asociativo con los datos de los vehículos:
     *   - id_vehiculo
     *   - placa
     *   - marca
     *   - modelo
     *   - cilindraje
     *   - id_usuario
     *   - propietario (nombre del usuario propietario)
     */
    public static function listar(): array
    {
        $db = Database::connect();

        return $db->query("
            SELECT v.*,
                   u.nombre AS propietario
            FROM vehiculo v
            JOIN usuario u ON u.id_usuario = v.id_usuario
        ")->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Buscar un vehículo por su ID
     *
     * @param int $id ID del vehículo
     * @return array|false Arreglo con los datos del vehículo o false si no existe
     */
    public static function buscar(int $id): array|false
    {
        $db = Database::connect();

        $stmt = $db->prepare("
            SELECT *
            FROM vehiculo
            WHERE id_vehiculo = ?
        ");

        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Crear un nuevo vehículo
     *
     * @param array $data Datos del vehículo:
     *   - placa
     *   - id_usuario (propietario)
     * @return int ID del vehículo creado
     */
    public static function crear(array $data): int
    {
        $db = Database::connect();

        $stmt = $db->prepare("
            INSERT INTO vehiculo
            (placa, id_usuario)
            VALUES (?, ?)
        ");

        $stmt->execute([
            $data['placa'],
            $data['id_usuario']
        ]);

        return (int) $db->lastInsertId();
    }

    /**
     * Listar vehículos asociados a un usuario
     *
     * @param int $idUsuario ID del usuario
     * @return array Arreglo con los vehículos del usuario
     */
    public static function listarPorUsuario(int $idUsuario): array
    {
        $db = Database::connect();

        $stmt = $db->prepare("
            SELECT *
            FROM vehiculo
            WHERE id_usuario = ?
        ");

        $stmt->execute([$idUsuario]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Verificar si un vehículo existe por su placa
     *
     * @param string $placa Placa del vehículo
     * @return bool true si existe, false si no
     */
    public static function existsByPlaca(string $placa): bool
    {
        $db = Database::connect();

        $stmt = $db->prepare("
            SELECT 1
            FROM vehiculo
            WHERE placa = ?
        ");

        $stmt->execute([$placa]);
        return (bool) $stmt->fetchColumn();
    }
}
