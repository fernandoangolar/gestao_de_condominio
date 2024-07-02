<?php
// TarefaManutencaoDTO.php

class TarefaManutencaoDTO {
    private $id;
    private $descricao;
    private $data;
    private $status;
    private $funcionario_id;
    private $prestadorServico_id;
    private $condominio_id;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    public function getData() {
        return $this->data;
    }

    public function setData($data) {
        $this->data = $data;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function getFuncionarioId() {
        return $this->funcionario_id;
    }

    public function setFuncionarioId($funcionario_id) {
        $this->funcionario_id = $funcionario_id;
    }

    public function getPrestadorServicoId() {
        return $this->prestadorServico_id;
    }

    public function setPrestadorServicoId($prestadorServico_id) {
        $this->prestadorServico_id = $prestadorServico_id;
    }

    public function getCondominioId() {
        return $this->condominio_id;
    }

    public function setCondominioId($condominio_id) {
        $this->condominio_id = $condominio_id;
    }
}
?>
