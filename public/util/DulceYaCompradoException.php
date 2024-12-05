<?php

// Definir la excepción DulceYaCompradoException
class DulceYaCompradoException extends Exception {
    
    // Constructor personalizado para la excepción
    public function __construct($message = "Este dulce ya ha sido comprado previamente.", $code = 0, Exception $previous = null) {
        // Llamar al constructor de la clase base (Exception)
        parent::__construct($message, $code, $previous);
    }

    // Método para obtener el mensaje de error
    public function errorMessage() {
        // Retornar el mensaje de error con la clase y el código de la excepción
        return "Error en el pedido: " . $this->getMessage();
    }
}

?>
