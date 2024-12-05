<?php

require_once 'PasteleriaException.php'; // Incluir la excepción base

class ClienteNoEncontradoException extends PasteleriaException {
    public function __construct($message = "El cliente no está registrado en la pastelería.", $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}

?>
