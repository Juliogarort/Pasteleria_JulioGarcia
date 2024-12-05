<?php
require_once 'Dulce.php';

class Tarta extends Dulce {
    private $relleno;
    private $pisos;
    private $minComensales;
    private $maxComensales;

    public function __construct($nombre, $precio, $categoria, $relleno, $pisos, $minComensales = 2, $maxComensales = 10) {
        parent::__construct($nombre, $precio, $categoria);
        $this->relleno = $relleno;
        $this->pisos = $pisos;
        $this->minComensales = $minComensales;
        $this->maxComensales = $maxComensales;
    }

    public function getTipo() {
        return "Tarta";
    }

    public function getRelleno() {
        return $this->relleno;
    }

    public function muestraResumen() {
        return "Tarta: {$this->nombre}, Precio: {$this->precio}, Categoría: {$this->categoria}, Relleno: {$this->relleno}, Pisos: {$this->pisos}, Comensales: {$this->minComensales}-{$this->maxComensales}";
    }
}
?>
