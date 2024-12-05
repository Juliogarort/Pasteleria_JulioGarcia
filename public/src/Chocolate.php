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

    public function getTipo() {
        return "Chocolate";
    }

    public function getRelleno() {
        return "No tiene relleno"; // Los chocolates no tienen relleno
    }

    public function muestraResumen() {
        return "Chocolate: {$this->nombre}, Precio: {$this->precio}, Cacao: {$this->porcentajeCacao}%, Peso: {$this->peso}g";
    }
}
?>
