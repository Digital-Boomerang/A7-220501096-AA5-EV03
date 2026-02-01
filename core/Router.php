<?php

class Router {

    private array $routes = [];

    // ================================
    // REGISTRO DE RUTAS
    // ================================
    public function get(string $path, array $handler) {
        $this->routes['GET'][$path] = $handler;
    }

    public function post(string $path, array $handler) {
        $this->routes['POST'][$path] = $handler;
    }

    public function put(string $path, array $handler) {
        $this->routes['PUT'][$path] = $handler;
    }

    public function delete(string $path, array $handler) {
        $this->routes['DELETE'][$path] = $handler;
    }

    // ================================
    // RESOLUCIÓN DE RUTAS
    // ================================
    public function resolve() {

        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        // Limpiar prefijo del proyecto
        $uri = str_replace('/cda-api/public', '', $uri);

        if (!isset($this->routes[$method])) {
            Response::json(["error" => "Método no permitido"], 405);
        }

        foreach ($this->routes[$method] as $route => $handler) {

            // Convertir /api/usuarios/{id} → regex
            $pattern = preg_replace('#\{[a-zA-Z_]+\}#', '([0-9]+)', $route);
            $pattern = "#^{$pattern}$#";

            if (preg_match($pattern, $uri, $matches)) {

                array_shift($matches); // quitar ruta completa

                [$class, $function] = $handler;
                $controller = new $class;

                // Pasar parámetros si existen
                call_user_func_array([$controller, $function], $matches);
                return;
            }
        }

        Response::json(["error" => "Ruta no encontrada"], 404);
    }
}
