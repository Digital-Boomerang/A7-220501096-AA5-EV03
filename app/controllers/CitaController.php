<?php

class CitaController {

    public function listar() {
        Response::json(Cita::listar());
    }

    public function obtener() {
        $id = $_GET["id"] ?? null;

        if (!$id) {
            Response::json(["error" => "ID requerido"], 400);
        }

        $cita = Cita::buscar($id);

        if (!$cita) {
            Response::json(["error" => "Cita no encontrada"], 404);
        }

        Response::json($cita);
    }

    public function crear() {
        $data = json_decode(file_get_contents("php://input"), true);

        $id = Cita::crear($data);

        Response::json([
            "mensaje" => "Cita creada",
            "id" => $id
        ], 201);
    }
}
