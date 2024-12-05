<?php

abstract class Dulce implements Resumible {
    protected $nombre;
    protected $precio;
    protected $categoria;

    // Constante estática para el IVA
    private static $IVA = 21;

    /**
     * Constructor de la clase Dulce
     *
     * @param string $nombre Nombre del dulce
     * @param float $precio Precio del dulce
     * @param string $categoria Categoría del dulce
     */
    public function __construct($nombre, $precio, $categoria) {
        $this->nombre = $nombre;
        $this->precio = $precio;
        $this->categoria = $categoria;
    }

    // Métodos getter
    public function getNombre() {
        return $this->nombre;
    }

    public function getPrecio() {
        return $this->precio;
    }

    public function getCategoria() {
        return $this->categoria;
    }

    // Método estático para obtener el IVA
    public static function getIVA() {
        return self::$IVA;
    }

    /**
     * Método abstracto muestraResumen()
     * 
     * Forzamos a las clases hijas a implementar este método,
     * ya que cada dulce tiene un resumen diferente.
     */
    abstract public function muestraResumen();

    /**
     * Método muestraInformacion()
     * 
     * Proporciona información básica del dulce. 
     * Puede ser sobrescrito por las clases hijas.
     */
    public function mostrarInformacion() {
        return "{$this->nombre} - Precio: {$this->precio}€";
    }

    /**
     * Comentario sobre la abstracción de la clase:
     * Al transformar esta clase en abstracta:
     * - Evitamos que se creen instancias de Dulce directamente,
     *   ya que esta clase representa un concepto genérico.
     * - Forzamos a las clases hijas (Bollo, Chocolate, Tarta) 
     *   a implementar el método abstracto `muestraResumen`.
     * - Garantizamos que el diseño del sistema sea más robusto
     *   y específico para las clases derivadas.
     */
}

?>