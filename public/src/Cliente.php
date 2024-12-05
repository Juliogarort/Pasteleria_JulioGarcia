<?php

require_once 'Dulces.php';  // Asegurémonos de que la clase Dulces esté incluida

class Cliente {
    // Atributos de la clase Cliente
    private $nombre;
    private $numero;
    private $numPedidosEfectuados;
    private $dulcesComprados; // Array para almacenar objetos de tipo Dulce
    private $comentarios;     // Array para almacenar comentarios de los dulces

    // Constructor
    public function __construct($nombre, $numero, $numPedidosEfectuados = 0) {
        $this->nombre = $nombre;
        $this->numero = $numero;
        $this->numPedidosEfectuados = $numPedidosEfectuados;
        $this->dulcesComprados = [];  // Inicializar el array vacío
        $this->comentarios = [];      // Inicializar el array de comentarios
    }

    // Métodos getter
    public function getNombre() {
        return $this->nombre;
    }

    public function getNumero() {
        return $this->numero;
    }

    public function getNumPedidosEfectuados() {
        return $this->numPedidosEfectuados;
    }

    public function getDulcesComprados() {
        return $this->dulcesComprados;
    }

    // Métodos setter
    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setNumero($numero) {
        $this->numero = $numero;
    }

    public function setNumPedidosEfectuados($numPedidosEfectuados) {
        $this->numPedidosEfectuados = $numPedidosEfectuados;
    }

    // Método para incrementar el número de pedidos efectuados
    public function incrementarPedidos() {
        $this->numPedidosEfectuados++;
    }

    // Método para agregar un dulce al array de dulcesComprados
    public function agregarDulce(Dulces $dulce) {
        $this->dulcesComprados[] = $dulce;
        $this->incrementarPedidos(); // Aumenta el contador de pedidos por cada dulce comprado
    }

    // Método para mostrar la información del cliente
    public function mostrarInformacion() {
        return "Cliente: $this->nombre, Número: $this->numero, Pedidos Efectuados: $this->numPedidosEfectuados";
    }

    // Método para mostrar los dulces comprados
    public function mostrarDulcesComprados() {
        $dulces = [];
        foreach ($this->dulcesComprados as $dulce) {
            $dulces[] = $dulce->mostrarInformacion();  // Mostrar información de cada dulce
        }
        return implode("\n", $dulces);  // Devolver todos los dulces en formato string
    }

    // Método para mostrar un resumen del cliente
    public function muestraResumen() {
        return "Cliente: $this->nombre, Cantidad de Pedidos: " . $this->numPedidosEfectuados;
    }

    // Método listaDeDulces
    public function listaDeDulces(Dulces $dulce) {
        // Recorre el array de dulcesComprados y comprueba si el dulce está presente
        foreach ($this->dulcesComprados as $dulceComprado) {
            // Compara los dulces (utilizamos el método getNombre de la clase Dulces para comparar)
            if ($dulceComprado->getNombre() === $dulce->getNombre()) {
                return true;  // El dulce ya está comprado
            }
        }
        return false;  // El dulce no está en la lista
    }

    // Método comprar
    public function comprar(Dulces $dulce) {
        // Comprobamos si el dulce ya está en el array
        if ($this->listaDeDulces($dulce)) {
            echo "El dulce '{$dulce->getNombre()}' ya ha sido comprado previamente.\n";
        } else {
            // Si el dulce no estaba en la lista, lo agregamos y aumentamos el contador de pedidos
            $this->agregarDulce($dulce);
            echo "Compra realizada: Se ha añadido '{$dulce->getNombre()}' a tu lista de compras.\n";
        }
    }

    // Método valorar
    public function valorar(Dulces $dulce, $comentario) {
        // Verificamos si el dulce ya ha sido comprado por el cliente
        if ($this->listaDeDulces($dulce)) {
            // Si ya lo compró, almacenamos el comentario
            $this->comentarios[$dulce->getNombre()] = $comentario;
            echo "Comentario sobre '{$dulce->getNombre()}': '$comentario'\n";
        } else {
            echo "No se puede valorar '{$dulce->getNombre()}', ya que no ha sido comprado aún.\n";
        }
    }

    // Método listarPedidos
    public function listarPedidos() {
        echo "Total de pedidos efectuados: " . $this->numPedidosEfectuados . "\n";
        echo "Detalles de los pedidos:\n";
        foreach ($this->dulcesComprados as $index => $dulce) {
            echo "Pedido " . ($index + 1) . ": " . $dulce->getNombre() . "\n";
        }
    }
}

?>
