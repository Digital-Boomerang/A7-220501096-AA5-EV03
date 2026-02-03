<?php

require_once __DIR__ . '/../models/Exportacion.php';
require_once __DIR__ . '/../../core/Response.php';

/**
 * Servicio para la gestión de exportaciones
 *
 * Contiene la lógica de negocio relacionada con la creación de registros de exportación.
 */
class ExportacionService
{
    /**
     * Registrar una nueva exportación
     *
     * Valida que los campos obligatorios estén presentes y luego
     * crea el registro en la base de datos.
     *
     * @param array $data Datos de la exportación: fecha, ruta_archivo
     */
    public static function registrar(array $data): void
    {
        // Validación de campos obligatorios
        if (
            empty($data['fecha']) ||
            empty($data['ruta_archivo']) ||
            empty($data['id_admin'])
        ) {
            Response::error(
                'Fecha, ruta de archivo e id_admin son obligatorios',
                400
            );
        }

        // Crear registro en el modelo Exportacion
        $exportacion = Exportacion::registrar($data);

        // Responder con éxito y código 201 (creado)
        Response::success(
            'Exportación registrada correctamente',
            $exportacion,
            201
        );
    }
}
