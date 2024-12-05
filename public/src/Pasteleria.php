<?php

require_once 'Dulce.php'; // Clase abstracta Dulce
require_once 'Bollo.php'; // Clase hija Bollo
require_once 'Chocolate.php'; // Clase hija Chocolate
require_once 'Tarta.php'; // Clase hija Tarta
require_once 'Cliente.php'; // Clase Cliente

class Pasteleria {
    private $productos = [];  // Array de productos (Dulces)
    private $clientes = [];   // Array de clientes

    public function agregarBollo($nombre, $precio, $categoria, $relleno) {
        $bollo = new Bollo($nombre, $precio, $categoria, $relleno);
        $this->incluirProducto($bollo);
        echo "Bollo '{$nombre}' agregado a la pastelería.\n";
    }

    public function agregarChocolate($nombre, $precio, $categoria, $porcentajeCacao, $peso) {
        $chocolate = new Chocolate($nombre, $precio, $categoria, $porcentajeCacao, $peso);
        $this->incluirProducto($chocolate);
        echo "Chocolate '{$nombre}' agregado a la pastelería.\n";
    }

    public function agregarTarta($nombre, $precio, $categoria, $relleno, $pisos, $minComensales = 2, $maxComensales = 10) {
        $tarta = new Tarta($nombre, $precio, $categoria, $relleno, $pisos, $minComensales, $maxComensales);
        $this->incluirProducto($tarta);
        echo "Tarta '{$nombre}' agregada a la pastelería.\n";
    }

    private function incluirProducto(Dulce $dulce) {
        $this->productos[] = $dulce;
    }

    public function mostrarProductos() {
        echo "Productos disponibles en la pastelería:\n";
        foreach ($this->productos as $producto) {
            echo $producto->muestraResumen() . "\n";
        }
    }

    public function agregarCliente($nombre, $numero) {
        $cliente = new Cliente($nombre, $numero);
        $this->clientes[] = $cliente;
        echo "Cliente '{$nombre}' registrado en la pastelería.\n";
    }

    public function mostrarClientes() {
        echo "Clientes registrados en la pastelería:\n";
        foreach ($this->clientes as $cliente) {
            echo $cliente->muestraResumen() . "\n";
        }
    }

    public function realizarPedido(Cliente $cliente, $nombreDulce) {
        $dulce = $this->buscarProductoPorNombre($nombreDulce);
        if ($dulce) {
            $cliente->comprar($dulce);
            echo "Pedido realizado: '{$cliente->getNombre()}' ha comprado '{$dulce->getNombre()}'.\n";
        } else {
            echo "El dulce '{$nombreDulce}' no está disponible en la pastelería.\n";
        }
    }

    private function buscarProductoPorNombre($nombre) {
        foreach ($this->productos as $producto) {
            if ($producto->getNombre() === $nombre) {
                return $producto;
            }
        }
        return null; // Si no se encuentra el producto
    }
}

?>
