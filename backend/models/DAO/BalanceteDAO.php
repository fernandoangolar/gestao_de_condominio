<?php 

include_once '../config/db.php';
include_once('../models/DTO/BalanceteDTO.php');
require_once __DIR__ . '/../../utils/CondominioNotFoundException.php';


class BalanceteDAO {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create(BalanceteDTO $balancete) {
        $query = "INSERT INTO Balancete (data, totalDespesas, totalReceitas, condominio_id) 
        VALUES (:data, :totalDespesas, :totalReceitas, :condominio_id)";

        $stmt = $this->conn->prepare($query);

        $data = $balancete->getData();
        $totalDespesas = $balancete->getTotalDespesas();
        $totalReceitas = $balancete->getTotalReceitas();
        $condominioId = $balancete->getCondominioId();

        $stmt->bindParam(':data', $data);
        $stmt->bindParam(':totalDespesas', $totalDespesas);
        $stmt->bindParam(':totalReceitas', $totalReceitas);
        $stmt->bindParam(':condominio_id', $condominioId);

        return $stmt->execute();
    }

    public function getBalancete($id) {
        $query = "SELECT * FROM Balancete WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $balancete = new BalanceteDTO();
            $balancete->setData($result['data']);
            $balancete->setTotalDespesas($result['totalDespesas']);
            $balancete->setTotalReceitas($result['totalReceitas']);
            $balancete->setCondominioId($result['condominio_id']);
            return $balancete;
        } else {
            return null; // Se o balancete não for encontrado, retorna null
        }
    }

    public function getById($id) {
        $query = "SELECT id, data, totalDespesas, totalReceitas, condominio_id FROM Balancete WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update(BalanceteDTO $balancete) {
        $query = "UPDATE Balancete SET data = :data, totalDespesas = :totalDespesas, totalReceitas = :totalReceitas, condominio_id = :condominio_id WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $id = $balancete->getId();
        $data = $balancete->getData();
        $totalDespesas = $balancete->getTotalDespesas();
        $totalReceitas = $balancete->getTotalReceitas();
        $condominioId = $balancete->getCondominioId();

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':data', $data);
        $stmt->bindParam(':totalDespesas', $totalDespesas);
        $stmt->bindParam(':totalReceitas', $totalReceitas);
        $stmt->bindParam(':condominio_id', $condominioId);

        try {
            $this->condominioExiste($balancete->getCondominioId()); // Verifica se o condomínio existe
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Erro ao atualizar balancete: " . $e->getMessage());
            return false;
        }
    }

    public function delete($id) {
        $query = "DELETE FROM Balancete WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    public function condominioExiste($condominioId) {
        $query = "SELECT COUNT(*) FROM condominio WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $condominioId);
        $stmt->execute();
        if ($stmt->fetchColumn() == 0) {
            throw new CondominioNotFoundException("Condomínio com ID $condominioId não encontrado.");
        }
    }
}

?>