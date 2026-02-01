<?php

class Response
{
    /**
     * Retorna una respuesta JSON estándar
     */
    public static function json($data, int $status = 200): void
    {
        http_response_code($status);
        header('Content-Type: application/json; charset=UTF-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }

    /**
     * Respuesta de error rápida
     */
    public static function error(string $message, int $status = 400): void
    {
        self::json([
            'error' => true,
            'message' => $message
        ], $status);
    }
}
