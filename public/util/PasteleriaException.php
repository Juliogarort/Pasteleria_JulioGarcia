<?php

// Excepción personalizada para la pastelería
class PasteleriaException extends Exception {
    // No es necesario sobrescribir ningún método si solo necesitas un comportamiento estándar.
    // Sin embargo, podrías agregar un constructor si necesitas un mensaje específico o un código de error.
    
    // Constructor para personalizar el mensaje y el código si es necesario
    public function __construct($message = "Error en la pastelería", $code = 0, Exception $previous = null) {
        // Llamamos al constructor de la clase base (Exception)
        parent::__construct($message, $code, $previous);
    }

    // Puedes agregar más métodos si necesitas personalizar más el comportamiento de la excepción.
}

?>
