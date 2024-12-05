<?php

require_once 'PasteleriaException.php'; // Incluir la excepción base

class DulceNoCompradoException extends PasteleriaException {
    public function __construct($message = "El dulce no ha sido comprado.", $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}

?>
