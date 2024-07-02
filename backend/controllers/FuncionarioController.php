<?php
include_once('../models/DAO/FuncionarioDAO.php');

class FuncionarioController {
    private $dao;

    public function __construct($db) {
        $this->dao = new FuncionarioDAO($db);
    }

    public function createFuncionario($data) {
        if (!$data->user_id || !$data->funcao || !$data->condominio_id) {
            http_response_code(400);
            echo json_encode(["message" => "Dados incompletos para criar o funcionário."]);
            return;
        }

        $funcionarioDTO = new FuncionarioDTO();
        $funcionarioDTO->setUserId($data->user_id);
        $funcionarioDTO->setFuncao($data->funcao);
        $funcionarioDTO->setCondominioId($data->condominio_id);

        if ($this->dao->create($funcionarioDTO)) {
            http_response_code(201);
            echo json_encode(["message" => "Funcionário criado com sucesso."]);
        } else {
            http_response_code(503);
            echo json_encode(["message" => "Não foi possível criar o funcionário."]);
        }
    }

    public function getFuncionario($id) {
        $result = $this->dao->getById($id);
        if ($result) {
            http_response_code(200);
            echo json_encode($result);
        } else {
            http_response_code(404);
            echo json_encode(["message" => "Funcionário não encontrado."]);
        }
    }

    public function updateFuncionario($id, $data) {
        $existing = $this->dao->getById($id);
        if (!$existing) {
            http_response_code(404);
            echo json_encode(["message" => "Funcionário não encontrado."]);
            return;
        }

        // $funcionarioDAO = new FuncionarioDAO();
        $funcionarioDTO = new FuncionarioDTO();
        $funcionarioDTO->setId($id);
        $funcionarioDTO->setUserId($data->user_id);
        $funcionarioDTO->setFuncao($data->funcao);
        $funcionarioDTO->setCondominioId($data->condominio_id);

         // Verifica a validade dos IDs
        if (!$this->dao->validateIds($data->user_id, $data->condominio_id)) {
            echo json_encode(array("message" => "Erro: ID de usuário ou condomínio inválido."));
            return;
        }

        if ($this->dao->update($funcionarioDTO)) {
            http_response_code(200);
            echo json_encode(["message" => "Funcionário atualizado com sucesso."]);
        } else {
            http_response_code(503);
            echo json_encode(["message" => "Não foi possível atualizar o funcionário."]);
        }
    }

    public function deleteFuncionario($id) {
        $existing = $this->dao->getById($id);
        if (!$existing) {
            http_response_code(404);
            echo json_encode(["message" => "Funcionário não encontrado."]);
            return;
        }

        if ($this->dao->delete($id)) {
            http_response_code(200);
            echo json_encode(["message" => "Funcionário deletado com sucesso."]);
        } else {
            http_response_code(503);
            echo json_encode(["message" => "Não foi possível deletar o funcionário."]);
        }
    }

    public function getAllFuncionarios() {
        $result = $this->dao->getAll();
        http_response_code(200);
        echo json_encode($result);
    }
}
?>
