<?php

// Se importa el servicio responsable de la lógica de negocio de comentarios
require_once __DIR__ . '/../services/ComentarioService.php';

/**
 * Controlador de Comentarios
 * 
 * Este controlador actúa como intermediario entre las rutas HTTP
 * y la capa de servicios. Su función es recibir la solicitud,
 * extraer los datos necesarios y delegar la operación al servicio.
 */
class ComentarioController
{
    /**
     * Lista todos los comentarios registrados
     * 
     * Método invocado desde una ruta de tipo GET.
     * No recibe parámetros ya que la consulta es global.
     */
    public function listar(): void
    {
        ComentarioService::listar();
    }

    /**
     * Crea un nuevo comentario
     * 
     * Lee el cuerpo de la petición HTTP en formato JSON,
     * lo convierte en un arreglo asociativo y lo envía
     * al servicio para su validación y persistencia.
     */
    public function crear(): void
    {
        // Obtiene el cuerpo de la solicitud HTTP
        $data = json_decode(file_get_contents("php://input"), true);

        ComentarioService::crear($data);
    }
}
