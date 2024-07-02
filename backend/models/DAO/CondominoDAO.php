<?php
// CondominoDAO.php

include_once __DIR__ . "../../../config/db.php";
include_once __DIR__ . '../../../models/DTO/CodominoDTO.php';

class CondominoDAO {
    private $db;

    public function __construct() {
        global $db;
        $this->db = $db;
    }

    public function create(CondominoDTO $condomino) {
        try {
            $query = "INSERT INTO Condomino (user_id, unidade_id, status) VALUES (:user_id, :unidade_id, :status)";
            $stmt = $this->db->prepare($query);

            $user_id = $condomino->getUserId();
            $unidade_id = $condomino->getUnidadeId();
            $status = $condomino->getStatus();

            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':unidade_id', $unidade_id);
            $stmt->bindParam(':status', $status);

            return $stmt->execute();
        } catch (PDOException $e) {
            // Aqui você pode tratar exceções de banco de dados
            echo "Erro ao criar condomino: " . $e->getMessage();
            return false;
        }
    }

    public function getById($id) {
        try {
            $query = "SELECT * FROM Condomino WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erro ao obter condomino por ID: " . $e->getMessage();
            return null;
        }
    }

    public function update(CondominoDTO $condomino) {
        try {
            $query = "UPDATE Condomino SET user_id = :user_id, unidade_id = :unidade_id, status = :status WHERE id = :id";
            $stmt = $this->db->prepare($query);

            $user_id = $condomino->getUserId();
            $unidade_id = $condomino->getUnidadeId();
            $status = $condomino->getStatus();
            $id = $condomino->getId();

            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':unidade_id', $unidade_id);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':id', $id);

            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Erro ao atualizar condomino: " . $e->getMessage();
            return false;
        }
    }

    public function delete($id) {
        try {
            $query = "DELETE FROM Condomino WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Erro ao deletar condomino: " . $e->getMessage();
            return false;
        }
    }
}
?>
