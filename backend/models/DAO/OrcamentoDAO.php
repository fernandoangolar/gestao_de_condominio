<?php
// OrcamentoDAO.php

include_once __DIR__ . '../../../config/db.php';
include_once '../models/DTO/OrcamentoDTO.php';

class OrcamentoDAO {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Criar um orçamento
    public function create(OrcamentoDTO $orcamento) {
        $query = "INSERT INTO Orcamento (ano, previsaoReceitas, previsaoDespesas, condominio_id) VALUES (:ano, :previsaoReceitas, :previsaoDespesas, :condominio_id)";
        $stmt = $this->conn->prepare($query);

        $ano = $orcamento->getAno();
        $previsaoReceitas = $orcamento->getPrevisaoReceitas();
        $previsaoDespesas = $orcamento->getPrevisaoDespesas();
        $condominio_id = $orcamento->getCondominioId();

        $stmt->bindParam(':ano', $ano);
        $stmt->bindParam(':previsaoReceitas', $previsaoReceitas);
        $stmt->bindParam(':previsaoDespesas', $previsaoDespesas);
        $stmt->bindParam(':condominio_id', $condominio_id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Obter orçamento por ID
    public function getById($id) {
        $query = "SELECT * FROM Orcamento WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return null;
    }

    // Atualizar orçamento
    public function update(OrcamentoDTO $orcamento) {
        $query = "UPDATE Orcamento SET ano = :ano, previsaoReceitas = :previsaoReceitas, previsaoDespesas = :previsaoDespesas, condominio_id = :condominio_id WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $id = $orcamento->getId();
        $ano = $orcamento->getAno();
        $previsaoReceitas = $orcamento->getPrevisaoReceitas();
        $previsaoDespesas = $orcamento->getPrevisaoDespesas();
        $condominio_id = $orcamento->getCondominioId();

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':ano', $ano);
        $stmt->bindParam(':previsaoReceitas', $previsaoReceitas);
        $stmt->bindParam(':previsaoDespesas', $previsaoDespesas);
        $stmt->bindParam(':condominio_id', $condominio_id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Deletar orçamento por ID
    public function delete($id) {
        $query = "DELETE FROM Orcamento WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>
