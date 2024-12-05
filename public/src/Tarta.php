<?php

require_once 'Dulce.php';

class Tarta extends Dulce {
    private $relleno;
    private $pisos;
    private $minNumComensales;
    private $maxNumComensales;

    public function __construct($nombre, $precio, $categoria, $relleno, $pisos, $minNumComensales = 2, $maxNumComensales = 10) {
        parent::__construct($nombre, $precio, $categoria);
        $this->relleno = $relleno;
        $this->pisos = $pisos;
        $this->minNumComensales = $minNumComensales;
        $this->maxNumComensales = $maxNumComensales;
    }

    public function getRelleno() {
        return $this->relleno;
    }

    public function getPisos() {
        return $this->pisos;
    }

    public function getMinNumComensales() {
        return $this->minNumComensales;
    }

    public function getMaxNumComensales() {
        return $this->maxNumComensales;
    }

    public function muestraComensalesPosibles() {
        if ($this->minNumComensales === $this->maxNumComensales) {
            return "Para {$this->minNumComensales} comensales.";
        } elseif ($this->maxNumComensales === null) {
            return "Para {$this->minNumComensales} o más comensales.";
        } else {
            return "De {$this->minNumComensales} a {$this->maxNumComensales} comensales.";
        }
    }

    // Implementación del método muestraResumen
    public function muestraResumen() {
        $rellenos = implode(", ", $this->relleno);
        return "Tarta: {$this->getNombre()} - Precio: {$this->getPrecio()}€ - Rellenos: {$rellenos} - Pisos: {$this->getPisos()} - Comensales: {$this->muestraComensalesPosibles()}";
    }
}

?>
