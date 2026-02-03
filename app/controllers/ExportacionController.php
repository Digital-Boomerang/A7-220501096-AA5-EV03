<?php

// Servicio encargado de la lógica de negocio relacionada con exportaciones
require_once __DIR__ . '/../services/ExportacionService.php';

// Clase utilitaria para enviar respuestas HTTP estandarizadas
require_once __DIR__ . '/../../core/Response.php';

/**
 * Controlador de Exportaciones
 *
 * Gestiona las solicitudes HTTP relacionadas con el registro
 * de procesos o datos de exportación. Su función es recibir
 * la información enviada por el cliente, validar su formato
 * básico y delegar el procesamiento al servicio correspondiente.
 */
class ExportacionController
{
    /**
     * Registra una nueva exportación
     *
     * Lee el cuerpo de la solicitud en formato JSON, valida que
     * la estructura sea correcta y envía los datos al servicio
     * para su procesamiento y almacenamiento.
     */
    public function registrar(): void
    {
        // Decodifica el cuerpo de la petición HTTP
        $data = json_decode(file_get_contents('php://input'), true);

        // Valida que el contenido recibido sea un JSON válido
        if (!is_array($data)) {
            Response::error('JSON inválido', 400);
        }

        ExportacionService::registrar($data);
    }
}
