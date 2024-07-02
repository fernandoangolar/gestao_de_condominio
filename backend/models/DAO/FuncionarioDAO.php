<?php
include_once __DIR__ . '../../../config/db.php';
include_once __DIR__ . '../../../models/DTO/FuncionarioDTO.php';

class FuncionarioDAO {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create(FuncionarioDTO $funcionario) {
        // Prepara a query de inserção
        $query = "INSERT INTO Funcionario (user_id, funcao, condominio_id) VALUES (:user_id, :funcao, :condominio_id)";
        $stmt = $this->conn->prepare($query);

        // Armazena os valores em variáveis antes de passá-los
        $userId = $funcionario->getUserId();
        $funcao = $funcionario->getFuncao();
        $condominioId = $funcionario->getCondominioId();

        // Verifica se os IDs fornecidos são válidos
        if (!$this->validateIds($userId, $condominioId)) {
            echo "Erro: ID de usuário ou condomínio inválido.";
            return false;
        }

        // Associa os parâmetros às variáveis
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':funcao', $funcao);
        $stmt->bindParam(':condominio_id', $condominioId);

        try {
            // Executa a query e verifica o sucesso
            if ($stmt->execute()) {
                echo "Funcionário criado com sucesso.";
                return true;
            } else {
                echo "Falha ao criar funcionário.";
                return false;
            }
        } catch (PDOException $e) {
            // Captura e exibe erros de execução
            echo "Erro: " . $e->getMessage();
            return false;
        }
    }

    public function getById($id) {
        $query = "SELECT * FROM Funcionario WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update(FuncionarioDTO $funcionario) {
        // Armazena os valores em variáveis antes de passá-los
        $userId = $funcionario->getUserId();
        $funcao = $funcionario->getFuncao();
        $condominioId = $funcionario->getCondominioId();
        $id = $funcionario->getId();

        // Valida os IDs antes de prosseguir
        if (!$this->validateIds($userId, $condominioId)) {
            echo "Erro: ID de usuário ou condomínio inválido.";
            return false;
        }

        // Se IDs válidos, prossegue com a atualização
        $query = "UPDATE Funcionario SET user_id = :user_id, funcao = :funcao, condominio_id = :condominio_id WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        // Associa os parâmetros às variáveis
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':funcao', $funcao);
        $stmt->bindParam(':condominio_id', $condominioId);
        $stmt->bindParam(':id', $id);

        // Tenta executar a query
        try {
            if ($stmt->execute()) {
                echo "Funcionário atualizado com sucesso.";
                return true;
            } else {
                echo "Falha ao atualizar funcionário.";
                return false;
            }
        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
            return false;
        }
    }

    public function delete($id) {
        $query = "DELETE FROM Funcionario WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function getAll() {
        $query = "SELECT * FROM Funcionario";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function validateIds($userId, $condominioId) {
        // Verifica se o user_id existe
        $queryUser = "SELECT COUNT(*) FROM User WHERE id = :user_id";
        $stmtUser = $this->conn->prepare($queryUser);
        $stmtUser->bindParam(':user_id', $userId);
        $stmtUser->execute();
        $userExists = $stmtUser->fetchColumn() > 0;

        // Verifica se o condominio_id existe
        $queryCondominio = "SELECT COUNT(*) FROM Condominio WHERE id = :condominio_id";
        $stmtCondominio = $this->conn->prepare($queryCondominio);
        $stmtCondominio->bindParam(':condominio_id', $condominioId);
        $stmtCondominio->execute();
        $condominioExists = $stmtCondominio->fetchColumn() > 0;

        return $userExists && $condominioExists;
    }
}
?>
