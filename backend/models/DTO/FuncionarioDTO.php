<?php
class FuncionarioDTO {
    private $id;
    private $user_id;
    private $funcao;
    private $condominio_id;

    public function __construct()
    {
        
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getUserId() {
        return $this->user_id;
    }

    public function setUserId($user_id) {
        $this->user_id = $user_id;
    }

    public function getFuncao() {
        return $this->funcao;
    }

    public function setFuncao($funcao) {
        $this->funcao = $funcao;
    }

    public function getCondominioId() {
        return $this->condominio_id;
    }

    public function setCondominioId($condominio_id) {
        $this->condominio_id = $condominio_id;
    }
}
?>
