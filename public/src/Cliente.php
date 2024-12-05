<?php

require_once 'Conexion.php'; // Incluir la clase de conexión
require_once 'Resumible.php'; // Asegúrate de incluir la interfaz Resumible
require_once 'DulceNoCompradoException.php'; // Excepción DulceNoComprado
require_once 'DulceYaCompradoException.php'; // Excepción DulceYaComprado

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

        // Guardamos el cliente en la base de datos cuando se crea
        $this->guardarClienteEnBD();
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
     * @return Cliente La instancia actual para encadenamiento de métodos
     */
    public function agregarDulce(Dulce $dulce) {
        $this->dulcesComprados[] = $dulce;
        $this->incrementarPedidos();
        // Actualizamos la base de datos con el número de pedidos
        $this->actualizarPedidosEnBD();
        return $this; // Permite el encadenamiento de métodos
    }

    /**
     * Realiza una compra de un dulce
     * 
     * @param Dulce $dulce Objeto Dulce que se compra
     * @throws DulceYaCompradoException Si el dulce ya ha sido comprado previamente
     * @return Cliente La instancia actual para encadenamiento de métodos
     */
    public function comprar(Dulce $dulce) {
        if ($this->listaDeDulces($dulce)) {
            throw new DulceYaCompradoException("El dulce '{$dulce->getNombre()}' ya ha sido comprado previamente.");
        } else {
            $this->agregarDulce($dulce);
            echo "Compra realizada: '{$dulce->getNombre()}' agregado a tu lista de compras.\n";
        }
        return $this; // Permite el encadenamiento de métodos
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
     * @throws DulceNoCompradoException Si el cliente intenta valorar un dulce que no ha comprado
     * @return Cliente La instancia actual para encadenamiento de métodos
     */
    public function valorar(Dulce $dulce, $comentario) {
        if ($this->listaDeDulces($dulce)) {
            $this->comentarios[$dulce->getNombre()] = $comentario;
            echo "Comentario registrado: '{$comentario}' sobre el dulce '{$dulce->getNombre()}'.\n";
        } else {
            throw new DulceNoCompradoException("No puedes valorar el dulce '{$dulce->getNombre()}', ya que no lo has comprado.");
        }
        return $this; // Permite el encadenamiento de métodos
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

    // Guardar el cliente en la base de datos
    private function guardarClienteEnBD() {
        $conexion = Conexion::obtenerInstancia()->obtenerConexion();
        $query = "INSERT INTO clientes (nombre, numero, num_pedidos) 
                  VALUES (:nombre, :numero, :num_pedidos)";
        $stmt = $conexion->prepare($query);
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':numero', $this->numero);
        $stmt->bindParam(':num_pedidos', $this->numPedidosEfectuados);
        $stmt->execute();
    }

    // Actualizar los pedidos en la base de datos cuando el cliente realiza una compra
    private function actualizarPedidosEnBD() {
        $conexion = Conexion::obtenerInstancia()->obtenerConexion();
        $query = "UPDATE clientes SET num_pedidos = :num_pedidos WHERE numero = :numero";
        $stmt = $conexion->prepare($query);
        $stmt->bindParam(':num_pedidos', $this->numPedidosEfectuados);
        $stmt->bindParam(':numero', $this->numero);
        $stmt->execute();
    }
}

?>
