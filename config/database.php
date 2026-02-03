<?php
// config/database.php
// Configuración de conexión a la base de datos usando PDO

class Database {

    public static function connect() {
        try {
            // Crear nueva conexión PDO a MySQL
            return new PDO(
                "mysql:host=localhost;dbname=cda_certimotos_prado;charset=utf8", // DSN: host, base de datos, charset
                "root",   // Usuario de la base de datos
                "",       // Contraseña
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Lanza excepciones en errores
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC // Devuelve resultados como arrays asociativos
                ]
            );
        } catch (PDOException $e) {
            // Si falla la conexión, termina la ejecución con mensaje de error
            die("Error de conexión a la base de datos: " . $e->getMessage());
        }
    }
}
