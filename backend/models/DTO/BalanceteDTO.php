<?php 

class BalanceteDTO {
    private $id;
    private $data;
    private $totalDespesas;
    private $totalReceitas;
    private $condominioId;

    public function __construct() {
    }

    // Getters e Setters omitidos para brevidade
    // Getters
    public function getId() {
        return $this->id;
    }

    public function getData() {
        return $this->data;
    }

    public function getTotalDespesas() {
        return $this->totalDespesas;
    }

    public function getTotalReceitas() {
        return $this->totalReceitas;
    }

    public function getCondominioId() {
        return $this->condominioId;
    }

    // Setters
    public function setId($id) {
        $this->id = $id;
    }

    public function setData($data) {
        $this->data = $data;
    }

    public function setTotalDespesas($totalDespesas) {
        $this->totalDespesas = $totalDespesas;
    }

    public function setTotalReceitas($totalReceitas) {
        $this->totalReceitas = $totalReceitas;
    }

    public function setCondominioId($condominioId) {
        $this->condominioId = $condominioId;
    }
}


?>