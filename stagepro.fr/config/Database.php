<?php
// config/Database.php

class Database {
    private static $instance = null;

    public static function getConnection() {
        if (self::$instance === null) {
            try {
                // Remplace par tes vrais identifiants si nécessaire
                self::$instance = new PDO(
                    "mysql:host=localhost;dbname=stagepro;charset=utf8", 
                    "root", 
                    ""
                );
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$instance->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                die("Erreur de connexion : " . $e->getMessage());
            }
        }
        return self::$instance;
    }
}