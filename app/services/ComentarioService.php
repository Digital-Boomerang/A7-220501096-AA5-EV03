<?php

require_once __DIR__ . '/../models/Comentario.php';
require_once __DIR__ . '/../../core/Response.php';

/**
 * Servicio de gestión de comentarios
 *
 * Contiene la lógica de negocio para listar y crear comentarios.
 */
class ComentarioService
{
    /**
     * Listar todos los comentarios
     *
     * Devuelve un listado de comentarios ordenados por fecha de publicación.
     */
    public static function listar(): void
    {
        Response::success(
            'Listado de comentarios',
            Comentario::listar()
        );
    }

    /**
     * Crear un nuevo comentario
     *
     * Valida que el nombre y mensaje estén presentes y que
     * el mensaje no supere los 300 caracteres.
     *
     * @param array $data Datos del comentario: nombre, mensaje
     */
    public static function crear(array $data): void
    {
        // Validación de campos obligatorios
        if (empty($data['nombre']) || empty($data['mensaje'])) {
            Response::error('Nombre y mensaje son obligatorios', 400);
        }

        // Validación de longitud del mensaje
        if (strlen($data['mensaje']) > 300) {
            Response::error('Mensaje demasiado largo', 400);
        }

        // Crear comentario y devolver respuesta exitosa
        Response::success(
            'Comentario creado correctamente',
            Comentario::crear($data),
            201
        );
    }
}
