<?php

class UsuarioController {

    public function listar() {
        $usuarios = Usuario::listar();
        Response::json($usuarios);
    }

    public function obtener() {
        $id = $_GET["id"] ?? null;

        if (!$id) {
            Response::json(["error" => "ID requerido"], 400);
        }

        $usuario = Usuario::buscar($id);

        if (!$usuario) {
            Response::json(["error" => "Usuario no encontrado"], 404);
        }

        Response::json($usuario);
    }

    public function crear() {
        $data = json_decode(file_get_contents("php://input"), true);

        $id = Usuario::crear($data);

        Response::json([
            "mensaje" => "Usuario creado",
            "id" => $id
        ], 201);
    }
}
