<?php

require_once 'Dulces.php';

class Bollo extends Dulces {
    // Atributo adicional de Bollo
    private $relleno;

    // Constructor sobrescrito
    public function __construct($nombre, $precio, $categoria, $relleno) {
        parent::__construct($nombre, $precio, $categoria);
        $this->relleno = $relleno;
    }

    // Método getter
    public function getRelleno() {
        return $this->relleno;
    }

    // Sobrescribir el método mostrarInformacion
    public function mostrarInformacion() {
        $infoBase = parent::mostrarInformacion(); // Llamar al método de la clase padre
        return $infoBase . ", Relleno: $this->relleno";
    }

    // Sobrescribir el método muestraResumen
    public function muestraResumen() {
        return "Resumen - Bollo: $this->nombre, Precio: " . number_format($this->precio, 2) . "€, Relleno: $this->relleno";
    }
}

?>