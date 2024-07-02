<?php

include_once __DIR__ . '../../../config/db.php';
include_once __DIR__ . '../../../models/DTO/PrestadorServicoDTO.php';

class PrestadorServicoDAO {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create(PrestadorServicoDTO $prestador) {
        $userId = $prestador->getUserId();
        if (!$this->userExists($userId)) {
            echo json_encode(array("message" => "Erro: ID de usuário inválido."));
            return false;
        }

        $query = "INSERT INTO PrestadorServico (user_id, tipo_servico, empresa_nome) VALUES (:user_id, :tipo_servico, :empresa_nome)";
        $stmt = $this->conn->prepare($query);

        $userId = $prestador->getUserId();
        $tipoServico = $prestador->getTipoServico();
        $empresaNome = $prestador->getEmpresaNome();

        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':tipo_servico', $tipoServico, PDO::PARAM_STR);
        $stmt->bindParam(':empresa_nome', $empresaNome, PDO::PARAM_STR);

        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
            return false;
        }
    }

    public function read($id) {
        $query = "SELECT * FROM PrestadorServico WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        try {
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
            return false;
        }
    }

    public function update(PrestadorServicoDTO $prestador) {
        $userId = $prestador->getUserId();
        if (!$this->userExists($userId)) {
            echo json_encode(array("message" => "Erro: ID de usuário inválido."));
            return false;
        }

        $query = "UPDATE PrestadorServico SET user_id = :user_id, tipo_servico = :tipo_servico, empresa_nome = :empresa_nome WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $userId = $prestador->getUserId();
        $tipoServico = $prestador->getTipoServico();
        $empresaNome = $prestador->getEmpresaNome();
        $id = $prestador->getId();

        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':tipo_servico', $tipoServico, PDO::PARAM_STR);
        $stmt->bindParam(':empresa_nome', $empresaNome, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
            return false;
        }
    }

    public function delete($id) {
        if (!$this->exists($id)) {
            return false; // Retorna falso se o ID não existir
        }

        $query = "DELETE FROM PrestadorServico WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
            return false;
        }
    }

    public function validateUserId($userId) {
        $query = "SELECT id FROM User WHERE id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function userExists($userId) {
        $query = "SELECT COUNT(id) as count FROM User WHERE id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['count'] > 0;
    }

    public function exists($id) {
        $query = "SELECT COUNT(id) as count FROM PrestadorServico WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['count'] > 0;
    }
}
?>
