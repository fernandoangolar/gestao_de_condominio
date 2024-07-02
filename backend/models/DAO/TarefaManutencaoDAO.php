<?php
// TarefaManutencaoDAO.php

include_once '../models/DTO/TarefaManutencaoDTO.php';

class TarefaManutencaoDAO {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Criar uma tarefa
    public function create(TarefaManutencaoDTO $tarefa) {
        $query = "INSERT INTO TarefaManutencao (descricao, data, status, funcionario_id, prestadorServico_id, condominio_id) 
                  VALUES (:descricao, :data, :status, :funcionario_id, :prestadorServico_id, :condominio_id)";
        $stmt = $this->conn->prepare($query);

        $descricao = $tarefa->getDescricao();
        $data = $tarefa->getData();
        $status = $tarefa->getStatus();
        $funcionario_id = $tarefa->getFuncionarioId();
        $prestadorServico_id = $tarefa->getPrestadorServicoId();
        $condominio_id = $tarefa->getCondominioId();

        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':data', $data);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':funcionario_id', $funcionario_id);
        $stmt->bindParam(':prestadorServico_id', $prestadorServico_id);
        $stmt->bindParam(':condominio_id', $condominio_id);

        return $stmt->execute();
    }

    // Obter tarefa por ID
    public function getById($id) {
        $query = "SELECT * FROM TarefaManutencao WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Atualizar tarefa
    public function update(TarefaManutencaoDTO $tarefa) {
        $query = "UPDATE TarefaManutencao SET descricao = :descricao, data = :data, status = :status, funcionario_id = :funcionario_id, prestadorServico_id = :prestadorServico_id, condominio_id = :condominio_id 
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $id = $tarefa->getId();
        $descricao = $tarefa->getDescricao();
        $data = $tarefa->getData();
        $status = $tarefa->getStatus();
        $funcionario_id = $tarefa->getFuncionarioId();
        $prestadorServico_id = $tarefa->getPrestadorServicoId();
        $condominio_id = $tarefa->getCondominioId();

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':data', $data);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':funcionario_id', $funcionario_id);
        $stmt->bindParam(':prestadorServico_id', $prestadorServico_id);
        $stmt->bindParam(':condominio_id', $condominio_id);

        return $stmt->execute();
    }

    // Deletar tarefa por ID
    public function delete($id) {
        $query = "DELETE FROM TarefaManutencao WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }
}
?>
