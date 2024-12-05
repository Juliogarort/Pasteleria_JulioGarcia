<?php

require_once 'Dulces.php';

class Chocolate extends Dulces {
    // Atributos adicionales de Chocolate
    private $porcentajeCacao;
    private $peso;

    // Constructor sobrescrito
    public function __construct($nombre, $precio, $categoria, $porcentajeCacao, $peso) {
        parent::__construct($nombre, $precio, $categoria);
        $this->porcentajeCacao = $porcentajeCacao;
        $this->peso = $peso;
    }

    // Métodos getter
    public function getPorcentajeCacao() {
        return $this->porcentajeCacao;
    }

    public function getPeso() {
        return $this->peso;
    }

    // Sobrescribir el método mostrarInformacion
    public function mostrarInformacion() {
        $infoBase = parent::mostrarInformacion(); // Llamar al método de la clase padre
        return $infoBase . ", Porcentaje de Cacao: $this->porcentajeCacao%, Peso: $this->peso g";
    }

    // Sobrescribir el método muestraResumen
    public function muestraResumen() {
        return "Resumen - Chocolate: $this->nombre, Precio: " . number_format($this->precio, 2) . "€, Cacao: $this->porcentajeCacao%, Peso: $this->peso g";
    }
}

?>