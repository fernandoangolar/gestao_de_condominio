<?php
// UnidadeDAO.php

include_once __DIR__ . "../../../config/db.php";
include_once __DIR__ . '../../../models/DTO/UnidadeDTO.php';

class UnidadeDAO {
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }

    // Método para criar uma nova unidade
    public function create($unidadeDTO) {
        $numero = $unidadeDTO->getNumero();
        $area = $unidadeDTO->getArea();
        $condominio_id = $unidadeDTO->getCondominioId();
    
        $query = "INSERT INTO Unidade (numero, area, condominio_id) VALUES (:numero, :area, :condominio_id)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':area', $area, PDO::PARAM_STR);
        $stmt->bindValue(':numero', $numero, PDO::PARAM_STR);
        $stmt->bindValue(':condominio_id', $condominio_id, PDO::PARAM_INT);
    
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Método para obter uma unidade pelo ID
    public function getById($id) {
        $query = "SELECT * FROM Unidade WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Método para atualizar uma unidade
    public function update($unidadeDTO) {
        $query = "UPDATE Unidade SET numero = :numero, condominio_id = :condominio_id, area = :area WHERE id = :id";
        $stmt = $this->db->prepare($query);
    
        // Obtém os dados do DTO
        $id = $unidadeDTO->getId();
        $numero = $unidadeDTO->getNumero();
        $condominio_id = $unidadeDTO->getCondominioId();
        $area = $unidadeDTO->getArea();
    
        // Associa os parâmetros
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':numero', $numero, PDO::PARAM_STR);
        $stmt->bindValue(':condominio_id', $condominio_id, PDO::PARAM_INT);
        $stmt->bindValue(':area', $area, PDO::PARAM_STR);
    
        // Executa a consulta
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Método para deletar uma unidade pelo ID
    public function delete($id) {
        $query = "DELETE FROM Unidade WHERE id = :id";
        $stmt = $this->db->prepare($query);
    
        // Associa o parâmetro :id
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    
        // Executa a consulta
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Método para buscar todas as unidades
    public function getAll() {
        $query = "SELECT u.id, u.numero, u.area, c.nome as condominio_nome FROM unidade u 
                  JOIN condominio c ON u.condominio_id = c.id";

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}
?>
