<?php

require_once 'PasteleriaException.php'; // Incluir la excepción base

class DulceNoEncontradoException extends PasteleriaException {
    public function __construct($message = "El dulce no se encuentra en la pastelería.", $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}

?>
