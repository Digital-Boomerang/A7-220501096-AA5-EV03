<?php

require_once __DIR__ . '/../../config/database.php';

/**
 * Modelo Credencial
 *
 * Gestiona la información de credenciales de los usuarios,
 * especialmente la búsqueda de contraseñas y datos de usuario
 * asociados a un correo electrónico.
 */
class Credencial
{
    /**
     * Buscar credencial por correo electrónico
     *
     * Realiza un join entre las tablas `credencial`, `usuario` y `rol`
     * para obtener la contraseña, información del usuario y rol.
     *
     * @param string $correo Correo electrónico del usuario a buscar
     * @return array|null Retorna un arreglo con:
     *   - contrasena: Contraseña hasheada
     *   - id_usuario: ID del usuario
     *   - nombre: Nombre del usuario
     *   - correo: Correo del usuario
     *   - id_rol: ID del rol
     *   - nombre_rol: Nombre del rol
     *  Retorna null si no se encuentra ninguna credencial
     */
    public static function buscarPorCorreo(string $correo): ?array
    {
        $db = Database::connect();

        $stmt = $db->prepare("
            SELECT 
                c.contrasena,
                u.id_usuario,
                u.nombre,
                u.correo,
                r.id_rol,
                r.nombre_rol
            FROM credencial c
            JOIN usuario u ON u.id_usuario = c.id_usuario
            JOIN rol r ON r.id_rol = u.id_rol
            WHERE u.correo = ?
            LIMIT 1
        ");

        $stmt->execute([$correo]);
        $result = $stmt->fetch();

        // Retorna null si no se encontró ningún registro
        return $result ?: null;
    }
}
