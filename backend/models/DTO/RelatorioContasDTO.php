<?php


class RelatorioContasDTO {
    private $id;
    private $ano;
    private $receitas;
    private $despesas;
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

    public function getReceitas() {
        return $this->receitas;
    }

    public function setReceitas($receitas) {
        $this->receitas = $receitas;
    }

    public function getDespesas() {
        return $this->despesas;
    }

    public function setDespesas($despesas) {
        $this->despesas = $despesas;
    }

    public function getCondominioId() {
        return $this->condominio_id;
    }

    public function setCondominioId($condominio_id) {
        $this->condominio_id = $condominio_id;
    }
}
?>
