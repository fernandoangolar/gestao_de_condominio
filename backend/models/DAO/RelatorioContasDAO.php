<?php
// RelatorioContasDAO.php

include_once __DIR__ . '../../../config/db.php';
include_once __DIR__ . '../../../models/DTO/RelatorioContasDTO.php';

class RelatorioContasDAO {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create(RelatorioContasDTO $relatorio) {
        $condominio_id = $relatorio->getCondominioId();
    
        // Verifica se o condominio_id existe na tabela Condominio
        if (!$this->condominioExiste($condominio_id)) {
            throw new CondominioNotFoundException("Condomínio com ID $condominio_id não encontrado.");
        }
    
        $query = "INSERT INTO RelatorioContas (ano, receitas, despesas, condominio_id) VALUES (:ano, :receitas, :despesas, :condominio_id)";
        $stmt = $this->conn->prepare($query);
    
        $ano = $relatorio->getAno();
        $receitas = $relatorio->getReceitas();
        $despesas = $relatorio->getDespesas();
    
        $stmt->bindParam(':ano', $ano);
        $stmt->bindParam(':receitas', $receitas);
        $stmt->bindParam(':despesas', $despesas);
        $stmt->bindParam(':condominio_id', $condominio_id);
    
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    

    // Obter relatório de contas por ID
    public function getById($id) {
        $query = "SELECT * FROM RelatorioContas WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return null;
    }

    // Atualizar relatório de contas
    public function update(RelatorioContasDTO $relatorio) {
        $condominio_id = $relatorio->getCondominioId();
    
        // Verifica se o condominio_id existe na tabela Condominio
        if (!$this->condominioExiste($condominio_id)) {
            throw new CondominioNotFoundException("Condomínio com ID $condominio_id não encontrado.");
        }
    
        $query = "UPDATE RelatorioContas SET ano = :ano, receitas = :receitas, despesas = :despesas, condominio_id = :condominio_id WHERE id = :id";
        $stmt = $this->conn->prepare($query);
    
        $id = $relatorio->getId();
        $ano = $relatorio->getAno();
        $receitas = $relatorio->getReceitas();
        $despesas = $relatorio->getDespesas();
    
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':ano', $ano);
        $stmt->bindParam(':receitas', $receitas);
        $stmt->bindParam(':despesas', $despesas);
        $stmt->bindParam(':condominio_id', $condominio_id);
    
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    
    public function delete($id) {
        $query = "DELETE FROM RelatorioContas WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
    
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    
    }

    public function condominioExiste($condominioId) {
        $query = "SELECT id FROM Condominio WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $condominioId);
        $stmt->execute();
        return $stmt->fetchColumn() > 0; // Retorna true se encontrar o condomínio, senão false
    }
    
}
?>
