<?php
// PagamentoDAO.php

include_once __DIR__ . '../../../config/db.php';
include_once '../models/DTO/PagamentoDTO.php';

class PagamentoDAO {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function create(PagamentoDTO $pagamento) {
        $query = "INSERT INTO Pagamento (data, valor, tipo, condomino_id) VALUES (:data, :valor, :tipo, :condomino_id)";
        $stmt = $this->conn->prepare($query);

        // Bind parameters
        $data = $pagamento->getData();
        $valor = $pagamento->getValor();
        $tipo = $pagamento->getTipo();
        $condomino_id = $pagamento->getCondominoId();

        $stmt->bindParam(':data', $data);
        $stmt->bindParam(':valor', $valor);
        $stmt->bindParam(':tipo', $tipo);
        $stmt->bindParam(':condomino_id', $condomino_id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getById($id) {
        $query = "SELECT * FROM Pagamento WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        $pagamento = new PagamentoDTO();
        $pagamento->setId($row['id']);
        $pagamento->setData($row['data']);
        $pagamento->setValor($row['valor']);
        $pagamento->setTipo($row['tipo']);
        $pagamento->setCondominoId($row['condomino_id']);

        return $pagamento;
    }

    public function update(PagamentoDTO $pagamento) {
        $query = "UPDATE Pagamento SET data = :data, valor = :valor, tipo = :tipo, condomino_id = :condomino_id WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        // Bind parameters
        $id = $pagamento->getId();
        $data = $pagamento->getData();
        $valor = $pagamento->getValor();
        $tipo = $pagamento->getTipo();
        $condomino_id = $pagamento->getCondominoId();

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':data', $data);
        $stmt->bindParam(':valor', $valor);
        $stmt->bindParam(':tipo', $tipo);
        $stmt->bindParam(':condomino_id', $condomino_id);

        try {
            $this->condominioExiste($pagamento->getCondominoId()); // Verifica se o condomínio existe
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Erro ao atualizar balancete: " . $e->getMessage());
            return false;
        }
    }

    public function delete($id) {
        $query = "DELETE FROM Pagamento WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getAll() {
        $query = "SELECT * FROM Pagamento";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $pagamentos = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $pagamento = new PagamentoDTO();
            $pagamento->setId($row['id']);
            $pagamento->setData($row['data']);
            $pagamento->setValor($row['valor']);
            $pagamento->setTipo($row['tipo']);
            $pagamento->setCondominoId($row['condomino_id']);

            $pagamentos[] = $pagamento;
        }

        return $pagamentos;
    }

    public function condominioExiste($condominioId) {
        $query = "SELECT id FROM Condomino WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $condominioId);
        $stmt->execute();
        if ($stmt->fetchColumn() == 0) {
            throw new CondominioNotFoundException("Condomínio com ID $condominioId não encontrado.");
        }
    }
}
?>
