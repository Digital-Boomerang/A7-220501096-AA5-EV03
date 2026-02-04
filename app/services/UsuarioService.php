<?php

require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../models/Rol.php';
require_once __DIR__ . '/../models/Credencial.php';
require_once __DIR__ . '/../../core/Response.php';

/**
 * Servicio para la gestión de usuarios
 *
 * Contiene la lógica de negocio para listar, crear, obtener y eliminar usuarios,
 * así como validaciones relacionadas con duplicados y roles.
 */
class UsuarioService
{
    /**
     * Listar todos los usuarios
     *
     * Recupera todos los usuarios desde la base de datos
     * y devuelve la información en formato JSON.
     */
    public static function listar(): void
    {
        Response::json(Usuario::listar());
    }

    /**
     * Obtener usuario por ID
     *
     * Valida que el usuario exista antes de devolverlo.
     */
    public static function obtener(int $id): void
    {
        $usuario = Usuario::buscar($id);

        if (!$usuario) {
            Response::error("Usuario no encontrado", 404);
        }

        Response::json($usuario);
    }

    /**
     * Crear un nuevo usuario
     *
     * Valida el rol, revisa duplicados y luego crea el usuario.
     */
    public static function crearUsuario(array $data): void
    {
        // Validar que se indique un rol
        if (empty($data['id_rol'])) {
            Response::error("Debe indicar un rol válido", 400);
        }

        // Validar duplicados (correo)
        self::validarDuplicados($data);

        // Validar existencia del rol
        if (!Rol::findById($data['id_rol'])) {
            Response::error("Rol no válido", 400);
        }

        // Crear usuario
        $id = Usuario::crear($data);

        Response::success(
            "Usuario creado correctamente",
            ["id" => $id],
            201
        );
    }

    /**
     * Actualizar un usuario por ID
     *
     * Valida existencia del usuario, rol y duplicados de correo.
     */
    public static function actualizar(int $id, array $data): void
    {
        $usuario = Usuario::buscar($id);
        if (!$usuario) {
            Response::error("Usuario no encontrado", 404);
        }

        // Validar campos mínimos
        if (empty($data['nombre']) || empty($data['correo']) || empty($data['telefono'])) {
            Response::error("Debe indicar nombre, correo y teléfono", 400);
        }

        if (empty($data['id_rol'])) {
            Response::error("Debe indicar un rol válido", 400);
        }

        // Validar duplicados (correo) excluyendo el usuario actual
        if (Usuario::existsByCorreoExceptId($data['correo'], $id)) {
            Response::error("El correo ya está registrado", 400);
        }

        // Validar existencia del rol
        if (!Rol::findById($data['id_rol'])) {
            Response::error("Rol no válido", 400);
        }

        Usuario::actualizar($id, $data);

        $actualizado = Usuario::buscar($id);
        Response::success("Usuario actualizado correctamente", $actualizado);
    }

    /**
     * Eliminar un usuario por ID
     *
     * Valida que el usuario exista antes de eliminarlo.
     */
    public static function eliminar(int $id): void
    {
        if (!Usuario::eliminar($id)) {
            Response::error("Usuario no encontrado", 404);
        }

        Response::success("Usuario eliminado correctamente");
    }

    /* ================================
       VALIDACIONES INTERNAS
       ================================ */

    /**
     * Validar correos duplicados
     *
     * Evita que se cree un usuario con un correo ya registrado.
     */
    private static function validarDuplicados(array $data): void
    {
        if (!empty($data['correo']) && Usuario::existsByCorreo($data['correo'])) {
            Response::error("El correo ya está registrado", 400);
        }
    }
}
