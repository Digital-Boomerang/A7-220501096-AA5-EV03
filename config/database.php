<?php
// config/database.php
// Database connection configuration

class Database {

    public static function connect() {
        try {
            return new PDO(
                "mysql:host=localhost;dbname=cda_certimotos_prado;charset=utf8",
                "root",
                "",
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );
        } catch (PDOException $e) {
            die("Error de conexión a la base de datos: " . $e->getMessage());
        }
    }
}
