<?php
require_once 'Dulce.php';

class Bollo extends Dulce {
    private $relleno;

    public function __construct($nombre, $precio, $categoria, $relleno) {
        parent::__construct($nombre, $precio, $categoria);
        $this->relleno = $relleno;
    }

    public function getTipo() {
        return "Bollo";
    }

    public function getRelleno() {
        return $this->relleno;
    }

    public function muestraResumen() {
        return "Bollo: {$this->nombre}, Precio: {$this->precio}, Relleno: {$this->relleno}";
    }
}
?>
