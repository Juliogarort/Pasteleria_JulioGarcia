<?php

require_once 'Dulce.php';

class Bollo extends Dulce {
    private $relleno;

    public function __construct($nombre, $precio, $categoria, $relleno) {
        parent::__construct($nombre, $precio, $categoria);
        $this->relleno = $relleno;
    }

    public function getRelleno() {
        return $this->relleno;
    }

    // Implementación del método muestraResumen
    public function muestraResumen() {
        return "Bollo: {$this->getNombre()} - Precio: {$this->getPrecio()}€ - Relleno: {$this->getRelleno()}";
    }
}

?>
