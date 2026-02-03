<?php

/**
 * Clase Router
 * -------------------------------------------------------
 * Enrutador principal de la API
 *
 * Responsabilidad:
 * - Registrar rutas HTTP
 * - Resolver la ruta solicitada
 * - Ejecutar el controlador correspondiente
 */
class Router
{
    /**
     * Rutas registradas por método HTTP
     * [
     *   'GET' => ['/api/usuarios' => [Controller, metodo]],
     *   'POST' => [...]
     * ]
     */
    private array $routes = [];

    // =====================================================
    // REGISTRO DE RUTAS
    // =====================================================

    /** Registrar ruta GET */
    public function get(string $path, array $handler): void
    {
        $this->routes['GET'][$path] = $handler;
    }

    /** Registrar ruta POST */
    public function post(string $path, array $handler): void
    {
        $this->routes['POST'][$path] = $handler;
    }

    /** Registrar ruta PUT */
    public function put(string $path, array $handler): void
    {
        $this->routes['PUT'][$path] = $handler;
    }

    /** Registrar ruta DELETE */
    public function delete(string $path, array $handler): void
    {
        $this->routes['DELETE'][$path] = $handler;
    }

    // =====================================================
    // RESOLUCIÓN DE RUTAS
    // =====================================================

    /**
     * Resuelve la petición HTTP actual
     * - Identifica método y URI
     * - Busca coincidencia
     * - Ejecuta el controlador
     */
    public function resolve(): void
    {
        // Método HTTP (GET, POST, PUT, DELETE)
        $method = $_SERVER['REQUEST_METHOD'];

        // URI sin query string
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        // Eliminar prefijo del proyecto (XAMPP)
        // Soporta base con o sin /public según configuración de rewrite
        $scriptDir = rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? ''), '/');
        $candidates = [$scriptDir];
        if (str_ends_with($scriptDir, '/public')) {
            $candidates[] = substr($scriptDir, 0, -7);
        }
        foreach ($candidates as $base) {
            if ($base !== '' && str_starts_with($uri, $base)) {
                $uri = substr($uri, strlen($base));
                if ($uri === '') {
                    $uri = '/';
                }
                break;
            }
        }

        // Método no soportado
        if (!isset($this->routes[$method])) {
            Response::error('Método HTTP no permitido', 405);
        }

        // Buscar coincidencia de ruta
        foreach ($this->routes[$method] as $route => $handler) {

            /**
             * Convertir rutas con parámetros:
             * /api/usuarios/{id}
             * → ^/api/usuarios/([0-9]+)$
             */
            $pattern = preg_replace(
                '#\{[a-zA-Z_]+\}#',
                '([0-9]+)',
                $route
            );

            $pattern = "#^{$pattern}$#";

            // ¿Coincide la ruta?
            if (preg_match($pattern, $uri, $matches)) {

                // Quitar coincidencia completa
                array_shift($matches);

                // Resolver controlador y método
                [$class, $function] = $handler;

                $controller = new $class();

                // Ejecutar método del controlador
                call_user_func_array(
                    [$controller, $function],
                    $matches
                );

                return;
            }
        }

        // Ruta no encontrada (404 real)
        Response::error('Ruta no encontrada', 404);
    }
}
