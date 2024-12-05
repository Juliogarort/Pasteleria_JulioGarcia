<?php

class Dulces {
    // Atributos de Dulce
    protected $nombre;
    protected $precio;
    protected $categoria;

    // Constante IVA
    const IVA = 21;

    // Constructor
    public function __construct($nombre, $precio, $categoria) {
        $this->nombre = $nombre;
        $this->precio = $precio;
        $this->categoria = $categoria;
    }

    // Métodos getter
    public function getNombre() {
        return $this->nombre;
    }

    public function getPrecio() {
        return $this->precio;
    }

    public function getCategoria() {
        return $this->categoria;
    }

    // Método para mostrar la información
    public function mostrarInformacion() {
        $precioConIVA = $this->precio + ($this->precio * self::IVA / 100);
        return "Dulce: $this->nombre, Precio: " . number_format($this->precio, 2) . "€, Precio con IVA: " . number_format($precioConIVA, 2) . "€, Categoría: $this->categoria";
    }

    // Método para mostrar el resumen
    public function muestraResumen() {
        return "Resumen - Dulce: $this->nombre, Precio: " . number_format($this->precio, 2) . "€";
    }

    // Método para obtener el IVA
    public static function getIVA() {
        return self::IVA;
    }
}

?>