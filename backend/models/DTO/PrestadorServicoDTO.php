<?php
class PrestadorServicoDTO {
    private $id;
    private $userId;
    private $tipoServico;
    private $empresaNome;

    // Getters e setters
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getUserId() {
        return $this->userId;
    }

    public function setUserId($userId) {
        $this->userId = $userId;
    }

    public function getTipoServico() {
        return $this->tipoServico;
    }

    public function setTipoServico($tipoServico) {
        $this->tipoServico = $tipoServico;
    }

    public function getEmpresaNome() {
        return $this->empresaNome;
    }

    public function setEmpresaNome($empresaNome) {
        $this->empresaNome = $empresaNome;
    }
}
?>
