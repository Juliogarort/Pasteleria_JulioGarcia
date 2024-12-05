<?php

require_once 'Resumible.php'; // Asegúrate de incluir la interfaz Resumible

class Cliente implements Resumible {
    private $nombre;
    private $numero;
    private $numPedidosEfectuados;
    private $dulcesComprados; // Array para almacenar los dulces comprados
    private $comentarios;     // Array para almacenar los comentarios de los dulces

    /**
     * Constructor de la clase Cliente
     *
     * @param string $nombre Nombre del cliente
     * @param string $numero Número de teléfono del cliente
     * @param int $numPedidosEfectuados Número de pedidos realizados
     */
    public function __construct($nombre, $numero, $numPedidosEfectuados = 0) {
        $this->nombre = $nombre;
        $this->numero = $numero;
        $this->numPedidosEfectuados = $numPedidosEfectuados;
        $this->dulcesComprados = [];
        $this->comentarios = [];
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

    private function incrementarPedidos() {
        $this->numPedidosEfectuados++;
    }

    /**
     * Agrega un dulce al cliente
     * 
     * @param Dulce $dulce Objeto Dulce que el cliente ha comprado
     */
    public function agregarDulce(Dulce $dulce) {
        $this->dulcesComprados[] = $dulce;
        $this->incrementarPedidos();
    }

    /**
     * Realiza una compra de un dulce
     * 
     * @param Dulce $dulce Objeto Dulce que se compra
     */
    public function comprar(Dulce $dulce) {
        if ($this->listaDeDulces($dulce)) {
            echo "El dulce '{$dulce->getNombre()}' ya ha sido comprado previamente.\n";
        } else {
            $this->agregarDulce($dulce);
            echo "Compra realizada: '{$dulce->getNombre()}' agregado a tu lista de compras.\n";
        }
    }

    /**
     * Verifica si el cliente ya ha comprado un dulce
     * 
     * @param Dulce $dulce Objeto Dulce
     * @return bool Verdadero si ya se compró, falso si no
     */
    private function listaDeDulces(Dulce $dulce) {
        foreach ($this->dulcesComprados as $dulceComprado) {
            if ($dulceComprado->getNombre() === $dulce->getNombre()) {
                return true;
            }
        }
        return false;
    }

    /**
     * Permite valorar un dulce que ya ha sido comprado
     * 
     * @param Dulce $dulce Objeto Dulce que el cliente valora
     * @param string $comentario Comentario sobre el dulce
     */
    public function valorar(Dulce $dulce, $comentario) {
        if ($this->listaDeDulces($dulce)) {
            $this->comentarios[$dulce->getNombre()] = $comentario;
            echo "Comentario registrado: '{$comentario}' sobre el dulce '{$dulce->getNombre()}'.\n";
        } else {
            echo "No puedes valorar el dulce '{$dulce->getNombre()}', ya que no lo has comprado.\n";
        }
    }

    /**
     * Método para mostrar un resumen del cliente
     *
     * @return string Resumen de los datos del cliente
     */
    public function muestraResumen() {
        return "Cliente: {$this->nombre}, Número: {$this->numero}, Pedidos: {$this->numPedidosEfectuados}";
    }

    /**
     * Lista todos los pedidos realizados por el cliente
     */
    public function listarPedidos() {
        echo "Pedidos de '{$this->nombre}':\n";
        foreach ($this->dulcesComprados as $dulce) {
            echo "- {$dulce->getNombre()}\n";
        }
    }
}

?>