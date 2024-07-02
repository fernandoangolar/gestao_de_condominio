<?php
// UnidadeDTO.php

class UnidadeDTO {
    private $id;
    private $numero;
    private $area;
    private $condominio_id;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getNumero() {
        return $this->numero;
    }

    public function setNumero($numero) {
        $this->numero = $numero;
    }

    public function getArea() {
        return $this->area;
    }

    public function setArea($area) {
        $this->area = $area;
    }

    public function getCondominioId() {
        return $this->condominio_id;
    }

    public function setCondominioId($condominio_id) {
        $this->condominio_id = $condominio_id;
    }
}
?>
