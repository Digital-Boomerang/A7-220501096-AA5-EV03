<?php

class AuthController {

    public function login() {

        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data["correo"], $data["contrasena"])) {
            Response::json(["error" => "Datos incompletos"], 400);
            return;
        }

        $usuario = Usuario::findByCorreo($data["correo"]);

        if (!$usuario) {
            Response::json(["error" => "Usuario no encontrado"], 401);
            return;
        }

        $hash = Credencial::getPassword($usuario["id_usuario"]);

        if (!$hash) {
            Response::json(["error" => "Credenciales inválidas"], 401);
            return;
        }

        if (!password_verify($data["contrasena"], $hash)) {
            Response::json(["error" => "Credenciales inválidas"], 401);
            return;
        }

        Response::json([
            "id"     => $usuario["id_usuario"],
            "nombre" => $usuario["nombre"],
            "correo" => $usuario["correo"],
            "rol"    => $usuario["nombre_rol"]
        ]);
    }
}
