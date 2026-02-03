<?php

require_once __DIR__ . '/../../config/database.php';

/**
 * Modelo Exportacion
 *
 * Gestiona el registro de exportaciones de datos del sistema.
 * Cada exportación tiene una fecha y una ruta de archivo asociada.
 */
class Exportacion
{
    /**
     * Registrar una nueva exportación
     *
     * Inserta un registro en la tabla `exportacion` con la fecha
     * y la ruta del archivo generado.
     *
     * @param array $data Arreglo con los datos de la exportación:
     *   - 'fecha': Fecha de la exportación (YYYY-MM-DD)
     *   - 'ruta_archivo': Ruta del archivo generado
     *   - 'id_admin': ID del administrador que genera la exportación
     *
     * @return array Retorna un arreglo con los datos registrados:
     *   - 'id': ID de la exportación recién creada
     *   - 'fecha': Fecha de la exportación
     *   - 'ruta_archivo': Ruta del archivo
     *   - 'id_admin': ID del administrador
     */
    public static function registrar(array $data): array
    {
        $db = Database::connect();

        $stmt = $db->prepare("
            INSERT INTO exportacion (fecha, ruta_archivo, id_admin)
            VALUES (:fecha, :ruta, :id_admin)
        ");

        $stmt->execute([
            ':fecha' => $data['fecha'],
            ':ruta'  => $data['ruta_archivo'],
            ':id_admin' => $data['id_admin']
        ]);

        // Retorna los datos de la exportación recién creada
        return [
            'id'           => $db->lastInsertId(),
            'fecha'        => $data['fecha'],
            'ruta_archivo' => $data['ruta_archivo'],
            'id_admin'     => $data['id_admin']
        ];
    }
}
