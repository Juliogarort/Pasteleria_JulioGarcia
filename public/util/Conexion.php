<?php

class Conexion {
    private static $instancia = null;
    private $conexion;

    // Configuración de la base de datos (ajústalo a tu entorno)
    private $host = 'localhost';
    private $usuario = 'root';
    private $password = '';
    private $baseDatos = 'Pasteleria';

    // Constructor privado para evitar instanciación externa
    private function __construct() {
        try {
            $this->conexion = new PDO(
                "mysql:host={$this->host};dbname={$this->baseDatos}", 
                $this->usuario, 
                $this->password
            );
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }

    // Método estático para obtener la única instancia
    public static function obtenerInstancia() {
        if (self::$instancia === null) {
            self::$instancia = new Conexion();
        }
        return self::$instancia;
    }

    // Obtener la conexión PDO
    public function obtenerConexion() {
        return $this->conexion;
    }

    // Evitar la clonación
    private function __clone() {}

    // Evitar la deserialización
    private function __wakeup() {}
}

?>
