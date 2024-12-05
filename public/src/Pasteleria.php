<?php

require_once 'Dulce.php'; // Clase abstracta Dulce
require_once 'Bollo.php'; // Clase hija Bollo
require_once 'Chocolate.php'; // Clase hija Chocolate
require_once 'Tarta.php'; // Clase hija Tarta
require_once 'Cliente.php'; // Clase Cliente
require_once 'DulceNoCompradoException.php'; // Excepción DulceNoComprado
require_once 'DulceYaCompradoException.php'; // Excepción DulceYaComprado
require_once 'DulceNoEncontradoException.php'; // Excepción DulceNoEncontrado
require_once 'ClienteNoEncontradoException.php'; // Excepción ClienteNoEncontrado
require_once 'PasteleriaException.php'; // Excepción de la pastelería

class Pasteleria {
    private $productos = [];  // Array de productos (Dulces)
    private $clientes = [];   // Array de clientes

    public function agregarBollo($nombre, $precio, $categoria, $relleno) {
        try {
            if ($this->buscarProductoPorNombre($nombre)) {
                // Lanza la excepción si el producto ya existe
                throw new PasteleriaException("El bollo '{$nombre}' ya está registrado.");
            }
            $bollo = new Bollo($nombre, $precio, $categoria, $relleno);
            $this->incluirProducto($bollo);
            echo "Bollo '{$nombre}' agregado a la pastelería.\n";
        } catch (PasteleriaException $e) {
            echo "Error: " . $e->getMessage() . "\n";
        }
    }

    public function agregarChocolate($nombre, $precio, $categoria, $porcentajeCacao, $peso) {
        try {
            if ($this->buscarProductoPorNombre($nombre)) {
                throw new PasteleriaException("El chocolate '{$nombre}' ya está registrado.");
            }
            $chocolate = new Chocolate($nombre, $precio, $categoria, $porcentajeCacao, $peso);
            $this->incluirProducto($chocolate);
            echo "Chocolate '{$nombre}' agregado a la pastelería.\n";
        } catch (PasteleriaException $e) {
            echo "Error: " . $e->getMessage() . "\n";
        }
    }

    public function agregarTarta($nombre, $precio, $categoria, $relleno, $pisos, $minComensales = 2, $maxComensales = 10) {
        try {
            if ($this->buscarProductoPorNombre($nombre)) {
                throw new PasteleriaException("La tarta '{$nombre}' ya está registrada.");
            }
            $tarta = new Tarta($nombre, $precio, $categoria, $relleno, $pisos, $minComensales, $maxComensales);
            $this->incluirProducto($tarta);
            echo "Tarta '{$nombre}' agregada a la pastelería.\n";
        } catch (PasteleriaException $e) {
            echo "Error: " . $e->getMessage() . "\n";
        }
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
        try {
            foreach ($this->clientes as $cliente) {
                if ($cliente->getNumero() === $numero) {
                    throw new PasteleriaException("El cliente con número '{$numero}' ya está registrado.");
                }
            }
            $cliente = new Cliente($nombre, $numero);
            $this->clientes[] = $cliente;
            echo "Cliente '{$nombre}' registrado en la pastelería.\n";
        } catch (PasteleriaException $e) {
            echo "Error: " . $e->getMessage() . "\n";
        }
    }

    public function mostrarClientes() {
        echo "Clientes registrados en la pastelería:\n";
        foreach ($this->clientes as $cliente) {
            echo $cliente->muestraResumen() . "\n";
        }
    }

    public function realizarPedido(Cliente $cliente, $nombreDulce) {
        try {
            // Intentamos buscar el dulce por nombre
            $dulce = $this->buscarProductoPorNombre($nombreDulce);
            
            if (!$dulce) {
                // Si no encontramos el dulce, lanzamos la excepción DulceNoEncontrado
                throw new DulceNoEncontradoException("El dulce '{$nombreDulce}' no está disponible en la pastelería.");
            }

            // Intentamos realizar la compra del dulce
            $cliente->comprar($dulce);  // Esto ya realiza la verificación de si el dulce ha sido comprado

            // Si la compra fue exitosa, muestra el mensaje
            echo "Pedido realizado: '{$cliente->getNombre()}' ha comprado '{$dulce->getNombre()}'.\n";
        } catch (DulceNoEncontradoException $e) {
            echo "Error: " . $e->getMessage() . "\n";
        } catch (DulceYaCompradoException $e) {
            echo "Error: " . $e->getMessage() . "\n";
        } catch (DulceNoCompradoException $e) {
            echo "Error: " . $e->getMessage() . "\n";
        } catch (ClienteNoEncontradoException $e) {
            echo "Error: " . $e->getMessage() . "\n";
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

    public function buscarClientePorNumero($numero) {
        foreach ($this->clientes as $cliente) {
            if ($cliente->getNumero() === $numero) {
                return $cliente;
            }
        }

        // Si no se encuentra el cliente, lanzamos la excepción ClienteNoEncontrado
        throw new ClienteNoEncontradoException("El cliente con número '{$numero}' no está registrado.");
    }
}
?>
