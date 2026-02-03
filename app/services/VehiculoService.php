<?php

/**
 * Servicio de dominio para la gestión de vehículos
 *
 * Contiene la lógica de negocio para crear, listar y obtener vehículos.
 * Valida que los usuarios existan antes de asociar vehículos.
 */

require_once __DIR__ . '/../models/Vehiculo.php';
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../../core/Response.php';

class VehiculoService
{
    /**
     * Crear un vehículo
     *
     * Valida la existencia del usuario asociado antes de crear el vehículo.
     * Devuelve la información completa del vehículo recién creado.
     */
    public static function crear(array $data): void
    {
        // Validación de negocio: se debe indicar un usuario válido
        if (empty($data['id_usuario'])) {
            Response::error('Debe asociar el vehículo a un usuario válido', 400);
        }

        // Validación de datos mínimos
        if (empty($data['placa'])) {
            Response::error('La placa es obligatoria', 400);
        }

        // Validar duplicados de placa
        if (Vehiculo::existsByPlaca($data['placa'])) {
            Response::error('La placa ya está registrada', 400);
        }

        // Verificar existencia del usuario en la base de datos
        $usuario = Usuario::buscarPorId((int)$data['id_usuario']);
        if (!$usuario) {
            Response::error('Usuario no encontrado', 404);
        }

        try {
            // Crear el vehículo y obtener el ID generado
            $idVehiculo = Vehiculo::crear([
                'placa' => $data['placa'],
                'id_usuario' => $data['id_usuario']
            ]);
        } catch (PDOException $e) {
            Response::error('No se pudo crear el vehículo', 400);
        }

        // Recuperar el vehículo completo para la respuesta
        $vehiculo = Vehiculo::buscar($idVehiculo);

        // Responder con el vehículo creado y código HTTP 201
        Response::json($vehiculo, 201);
    }

    /**
     * Listar todos los vehículos
     *
     * Devuelve todos los vehículos con información del propietario.
     */
    public static function listar(): void
    {
        Response::json(Vehiculo::listar());
    }

    /**
     * Listar vehículos de un usuario específico
     *
     * Verifica que el usuario exista antes de consultar sus vehículos.
     */
    public static function listarPorUsuario(int $idUsuario): void
    {
        // Validar existencia del usuario
        $usuario = Usuario::buscarPorId($idUsuario);
        if (!$usuario) {
            Response::error('Usuario no encontrado', 404);
        }

        // Devolver todos los vehículos asociados al usuario
        Response::json(Vehiculo::listarPorUsuario($idUsuario));
    }
}
