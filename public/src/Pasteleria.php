<?php

require_once 'Dulces.php';  // Asegurémonos de que la clase Dulces esté incluida
require_once 'Cliente.php';  // Incluir la clase Cliente

class Pasteleria {
    // Atributos de la clase Pastelería
    private $productos = []; // Array de productos (Dulces)
    private $clientes = [];  // Array de clientes

    // Método público para agregar un bollo a la pastelería
    public function agregarBollo($nombre, $precio, $categoria, $relleno) {
        $bollo = new Bollo($nombre, $precio, $categoria, $relleno);
        $this->incluirProducto($bollo);
        echo "Bollo '{$nombre}' agregado a la pastelería.\n";
    }

    // Método público para agregar un chocolate a la pastelería
    public function agregarChocolate($nombre, $precio, $categoria, $porcentajeCacao, $peso) {
        $chocolate = new Chocolate($nombre, $precio, $categoria, $porcentajeCacao, $peso);
        $this->incluirProducto($chocolate);
        echo "Chocolate '{$nombre}' agregado a la pastelería.\n";
    }

    // Método público para agregar una tarta a la pastelería
    public function agregarTarta($nombre, $precio, $categoria, $relleno, $pisos, $minComensales = 2, $maxComensales = 10) {
        $tarta = new Tarta($nombre, $precio, $categoria, $relleno, $pisos, $minComensales, $maxComensales);
        $this->incluirProducto($tarta);
        echo "Tarta '{$nombre}' agregada a la pastelería.\n";
    }

    // Método privado para agregar el dulce al array de productos
    private function incluirProducto(Dulces $dulce) {
        $this->productos[] = $dulce;
    }

    // Método para mostrar todos los productos disponibles en la pastelería
    public function mostrarProductos() {
        echo "Productos disponibles en la pastelería:\n";
        foreach ($this->productos as $producto) {
            echo $producto->mostrarInformacion() . "\n";
        }
    }

    // Método para mostrar todos los clientes registrados
    public function mostrarClientes() {
        echo "Clientes registrados en la pastelería:\n";
        foreach ($this->clientes as $cliente) {
            echo $cliente->mostrarInformacion() . "\n";
        }
    }

    // Método para realizar un pedido por parte de un cliente
    public function realizarPedido(Cliente $cliente, Dulces $dulce) {
        // Verificar si el dulce está disponible en la pastelería
        if ($this->verificarProducto($dulce)) {
            // Si el cliente no ha comprado previamente, procedemos a realizar el pedido
            $cliente->comprar($dulce);
        } else {
            echo "El dulce '{$dulce->getNombre()}' no está disponible en la pastelería.\n";
        }
    }

    // Método para verificar si un dulce está en el catálogo de la pastelería
    public function verificarProducto(Dulces $dulce) {
        foreach ($this->productos as $producto) {
            if ($producto->getNombre() === $dulce->getNombre()) {
                return true;  // El producto está disponible
            }
        }
        return false;  // El producto no está disponible
    }
}

?>