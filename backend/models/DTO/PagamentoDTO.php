<?php 

// Pagamento.php (Classe Pagamento)

class PagamentoDTO {
    private $id;
    private $data;
    private $valor;
    private $tipo;
    private $condomino_id;

    public function __construct() {

    }

    // Getters e Setters
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getData() {
        return $this->data;
    }

    public function setData($data) {
        $this->data = $data;
    }

    public function getValor() {
        return $this->valor;
    }

    public function setValor($valor) {
        $this->valor = $valor;
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    public function getCondominoId() {
        return $this->condomino_id;
    }

    public function setCondominoId($condomino_id) {
        $this->condomino_id = $condomino_id;
    }
}


?>