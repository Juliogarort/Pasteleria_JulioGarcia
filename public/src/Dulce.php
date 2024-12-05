<?php
abstract class Dulce {
    protected $nombre;
    protected $precio;
    protected $categoria;

    public function __construct($nombre, $precio, $categoria) {
        $this->nombre = $nombre;
        $this->precio = $precio;
        $this->categoria = $categoria;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getPrecio() {
        return $this->precio;
    }

    public function getCategoria() {
        return $this->categoria;
    }

    // Métodos abstractos que las clases hijas deben implementar
    abstract public function getTipo();
    abstract public function getRelleno();
    abstract public function muestraResumen();
}
?>
