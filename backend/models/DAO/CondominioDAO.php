<?php
include_once '../config/db.php';
include_once '../models/DTO/CondominioDTO.php';

class CondominioDAO {
    private $db;

    public function __construct() {
        global $db;
        $this->db = $db;
    }

    public function create(CondominioDTO $condominio) {
        $query = "INSERT INTO Condominio (nome, endereco) VALUES (:nome, :endereco)";
        $stmt = $this->db->prepare($query);

        $nome = $condominio->getNome();
        $endereco = $condominio->getEndereco();

        $stmt->bindValue(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindValue(':endereco', $endereco, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getById($id) {
        $query = "SELECT * FROM Condominio WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update(CondominioDTO $condominio) {
        $query = "UPDATE Condominio SET nome = :nome, endereco = :endereco WHERE id = :id";
        $stmt = $this->db->prepare($query);

        $id = $condominio->getId();
        $nome = $condominio->getNome();
        $endereco = $condominio->getEndereco();

        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindValue(':endereco', $endereco, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function delete($id) {
        $query = "DELETE FROM Condominio WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getAllNames() {
        $query = "SELECT nome FROM condominio";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        $nomesCondominios = $stmt->fetchAll(PDO::FETCH_COLUMN);
        return $nomesCondominios;
    }

    // Método para obter todos os condomínios (apenas nome)
    public function getAll() {
        $query = "SELECT id, nome FROM condominio";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
