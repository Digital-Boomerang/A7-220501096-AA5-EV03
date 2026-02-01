<?php

class HorarioController {

    public function listar() {
        Response::json(Horario::listar());
    }

    public function obtener() {
        $id = $_GET["id"] ?? null;

        if (!$id) {
            Response::json(["error" => "ID requerido"], 400);
        }

        $horario = Horario::buscar($id);

        if (!$horario) {
            Response::json(["error" => "Horario no encontrado"], 404);
        }

        Response::json($horario);
    }

    public function crear() {
        $data = json_decode(file_get_contents("php://input"), true);

        $id = Horario::crear($data);

        Response::json([
            "mensaje" => "Horario creado",
            "id" => $id
        ], 201);
    }
}
