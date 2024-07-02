<?php
// TarefaManutencaoController.php

include_once '../models/DAO/TarefaManutencaoDAO.php';

class TarefaManutencaoController {
    private $tarefaDAO;

    public function __construct($db) {
        $this->tarefaDAO = new TarefaManutencaoDAO($db);
    }

    // Criar uma tarefa
    public function createTarefa($data) {
        $tarefa = new TarefaManutencaoDTO();
        $tarefa->setDescricao($data->descricao);
        $tarefa->setData($data->data);
        $tarefa->setStatus($data->status);
        $tarefa->setFuncionarioId($data->funcionario_id);
        $tarefa->setPrestadorServicoId($data->prestadorServico_id);
        $tarefa->setCondominioId($data->condominio_id);

        if ($this->tarefaDAO->create($tarefa)) {
            echo json_encode(array("message" => "Tarefa de manutenção criada com sucesso."));
        } else {
            echo json_encode(array("message" => "Não foi possível criar a tarefa de manutenção."));
        }
    }

    // Obter tarefa por ID
    public function getTarefa($id) {
        $result = $this->tarefaDAO->getById($id);
        if ($result) {
            echo json_encode($result);
        } else {
            echo json_encode(array("message" => "Tarefa de manutenção não encontrada."));
        }
    }

    // Atualizar tarefa
    public function updateTarefa($id, $data) {

        $relatorioExistente = $this->tarefaDAO->getById($id);
        if (!$relatorioExistente) {
            http_response_code(404); // Not found
            echo json_encode(["message" => "Relatório de contas não encontrado."]);
            return;
        }

        $tarefa = new TarefaManutencaoDTO();
        $tarefa->setId($id);
        $tarefa->setDescricao($data->descricao);
        $tarefa->setData($data->data);
        $tarefa->setStatus($data->status);
        $tarefa->setFuncionarioId($data->funcionario_id);
        $tarefa->setPrestadorServicoId($data->prestadorServico_id);
        $tarefa->setCondominioId($data->condominio_id);

        if ($this->tarefaDAO->update($tarefa)) {
            http_response_code(200);
            echo json_encode(array("message" => "Tarefa de manutenção atualizada com sucesso."));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "Não foi possível atualizar a tarefa de manutenção."));
        }
    }

    // Deletar tarefa por ID
    public function deleteTarefa($id) {

        $existing = $this->tarefaDAO->getById($id);
        if (!$existing) {
            http_response_code(404);
            echo json_encode(["message" => "Tarefa não encontrado."]);
            return;
        }


        if ($this->tarefaDAO->delete($id)) {
            http_response_code(200);
            echo json_encode(array("message" => "Tarefa de manutenção excluída comsucesso."));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "Não foi possível excluir a tarefa de manutenção."));
        }
    }
}
?>  