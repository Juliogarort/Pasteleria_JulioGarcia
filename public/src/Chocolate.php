<?php

require_once 'Dulce.php';

class Chocolate extends Dulce {
    private $porcentajeCacao;
    private $peso;

    public function __construct($nombre, $precio, $categoria, $porcentajeCacao, $peso) {
        parent::__construct($nombre, $precio, $categoria);
        $this->porcentajeCacao = $porcentajeCacao;
        $this->peso = $peso;
    }

    public function getPorcentajeCacao() {
        return $this->porcentajeCacao;
    }

    public function getPeso() {
        return $this->peso;
    }

    // Implementación del método muestraResumen
    public function muestraResumen() {
        return "Chocolate: {$this->getNombre()} - Precio: {$this->getPrecio()}€ - Cacao: {$this->getPorcentajeCacao()}% - Peso: {$this->getPeso()}g";
    }
}

?>
