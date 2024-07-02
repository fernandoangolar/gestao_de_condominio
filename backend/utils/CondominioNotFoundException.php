<?php
class CondominioNotFoundException extends Exception {
    public function __construct($message = "Condomínio não encontrado", $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}
?>