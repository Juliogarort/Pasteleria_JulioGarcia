<?php

require_once 'Dulces.php';

class Tarta extends Dulces {
    // Atributos específicos de Tarta
    private $relleno;
    private $numPisos;
    private $minNumComensales;
    private $maxNumComensales;

    // Constructor sobrescrito
    public function __construct($nombre, $precio, $categoria, $relleno, $numPisos, $maxNumComensales, $minNumComensales = 2) {
        // Llamar al constructor de la clase padre
        parent::__construct($nombre, $precio, $categoria);

        // Inicializar atributos específicos
        $this->relleno = is_array($relleno) ? $relleno : [$relleno]; // Convertir a array si no lo es
        $this->numPisos = $numPisos;
        $this->maxNumComensales = $maxNumComensales;
        $this->minNumComensales = $minNumComensales;

        // Validación: relleno debe tener tantos elementos como pisos
        if (count($this->relleno) !== $this->numPisos) {
            throw new Exception("El número de rellenos debe coincidir con el número de pisos.");
        }
    }

    // Métodos getter
    public function getRelleno() {
        return $this->relleno;
    }

    public function getNumPisos() {
        return $this->numPisos;
    }

    public function getMinNumComensales() {
        return $this->minNumComensales;
    }

    public function getMaxNumComensales() {
        return $this->maxNumComensales;
    }

    // Sobrescribir el método mostrarInformacion
    public function mostrarInformacion() {
        $infoBase = parent::mostrarInformacion(); // Llamar al método de la clase padre
        $rellenoInfo = implode(", ", $this->relleno);
        return $infoBase . ", Relleno: [$rellenoInfo], Número de pisos: $this->numPisos, Comensales: $this->minNumComensales-$this->maxNumComensales";
    }

    // Sobrescribir el método muestraResumen
    public function muestraResumen() {
        $rellenoInfo = implode(", ", $this->relleno);
        return "Resumen - Tarta: $this->nombre, Precio: " . number_format($this->precio, 2) . "€, Pisos: $this->numPisos, Relleno: [$rellenoInfo], Comensales: $this->minNumComensales-$this->maxNumComensales";
    }

    // Método para mostrar el rango de comensales posibles
    public function muestraComensalesPosibles() {
        if ($this->minNumComensales == $this->maxNumComensales) {
            return "Para $this->minNumComensales comensales";
        } elseif ($this->minNumComensales == 2) {
            return "Para dos comensales";
        } else {
            return "De $this->minNumComensales a $this->maxNumComensales comensales";
        }
    }
}

?>
