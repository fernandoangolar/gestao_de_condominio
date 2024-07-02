<?php
// OrcamentoDTO.php

class OrcamentoDTO {
    private $id;
    private $ano;
    private $previsaoReceitas;
    private $previsaoDespesas;
    private $condominio_id;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getAno() {
        return $this->ano;
    }

    public function setAno($ano) {
        $this->ano = $ano;
    }

    public function getPrevisaoReceitas() {
        return $this->previsaoReceitas;
    }

    public function setPrevisaoReceitas($previsaoReceitas) {
        $this->previsaoReceitas = $previsaoReceitas;
    }

    public function getPrevisaoDespesas() {
        return $this->previsaoDespesas;
    }

    public function setPrevisaoDespesas($previsaoDespesas) {
        $this->previsaoDespesas = $previsaoDespesas;
    }

    public function getCondominioId() {
        return $this->condominio_id;
    }

    public function setCondominioId($condominio_id) {
        $this->condominio_id = $condominio_id;
    }
}
?>
