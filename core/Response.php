<?php

/**
 * Clase Response
 * ---------------------------------------------------------
 * Maneja todas las respuestas HTTP de la API en formato JSON
 *
 * Objetivo:
 * - Centralizar la salida de respuestas
 * - Mantener un formato estándar
 * - Simular el comportamiento de Spring Boot
 *
 * Estructura de respuesta:
 * {
 *   success: boolean,
 *   status: number,
 *   timestamp: string,
 *   data: mixed | null,
 *   error: mixed | null
 * }
 */
class Response
{
    /**
     * Respuesta JSON genérica
     * -----------------------------------------------------
     * MÉTODO BASE (USO INTERNO)
     *
     * ⚠️ NO debe usarse directamente para errores.
     * Para errores usar SIEMPRE Response::error()
     *
     * @param mixed  $data     Datos a retornar
     * @param int    $status   Código HTTP
     * @param bool   $success  Indica si la operación fue exitosa
     *
     * Ejemplo (uso interno):
     * Response::json($data, 200, true);
     */
    public static function json(
        mixed $data,
        int $status = 200,
        bool $success = true
    ): void {
        // Define el código de respuesta HTTP
        http_response_code($status);

        // Fuerza respuesta JSON con UTF-8
        header('Content-Type: application/json; charset=UTF-8');

        // Respuesta estandarizada
        echo json_encode([
            'success'   => $success,
            'status'    => $status,
            'timestamp' => date('Y-m-d H:i:s'),
            'data'      => $success ? $data : null,
            'error'     => $success ? null : $data
        ], JSON_UNESCAPED_UNICODE);

        // Detiene la ejecución (equivalente a throw exception)
        exit;
    }

    /**
     * Respuesta de error estándar
     * -----------------------------------------------------
     * Equivalente conceptual a:
     * - IllegalArgumentException
     * - EntityNotFoundException
     * - ResponseStatusException
     *
     * USO OBLIGATORIO para errores
     *
     * @param string $message Mensaje de error
     * @param int    $status  Código HTTP (400, 401, 403, 404, 500...)
     *
     * Ejemplo:
     * Response::error('Usuario no encontrado', 404);
     */
    public static function error(
        string $message,
        int $status = 400
    ): void {
        self::json([
            'message' => $message
        ], $status, false);
    }

    /**
     * Respuesta de éxito simple
     * -----------------------------------------------------
     * Usada principalmente en:
     * - POST
     * - PUT
     * - DELETE
     *
     * Simula respuestas tipo:
     * ResponseEntity.ok(...)
     *
     * @param string $message Mensaje de confirmación
     * @param mixed  $data    Resultado opcional
     * @param int    $status  Código HTTP (200, 201)
     *
     * Ejemplo:
     * Response::success('Usuario creado', $usuario, 201);
     */
    public static function success(
        string $message,
        mixed $data = null,
        int $status = 200
    ): void {
        self::json([
            'message' => $message,
            'result'  => $data
        ], $status, true);
    }
}
