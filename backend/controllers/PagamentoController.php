<?php
// PagamentoController.php

include_once '../models/DTO/PagamentoDTO.php';
include_once '../models/DAO/PagamentoDAO.php';

class PagamentoController {
    private $pagamentoDAO;

    public function __construct() {
        $this->pagamentoDAO = new PagamentoDAO();
    }

    // Método para criar um novo pagamento
    public function createPagamento($data) {
        // Validar os dados recebidos, se necessário
        // Exemplo: Verificar se todos os campos obrigatórios estão presentes

        if (!isset($data->data) || !isset($data->valor) || !isset($data->tipo) || !isset($data->condomino_id)) {
            http_response_code(400); // Bad request
            echo json_encode(array("message" => "Erro: Todos os campos (data, valor, tipo, condomino_id) são obrigatórios."));
            return;
        }

        
        if ($this->pagamentoDAO->condominioExiste($data->condomino_id)) {
            $pagamento = new PagamentoDTO();
            $pagamento->setData($data->data);
            $pagamento->setValor($data->valor);
            $pagamento->setTipo($data->tipo);
            $pagamento->setCondominoId($data->condomino_id);

            if ($this->pagamentoDAO->create($pagamento)) {
                http_response_code(201); // Created
                echo json_encode(array("message" => "Pagamento criado com sucesso."));
            } else {
                http_response_code(503); // Service Unavailable
                echo json_encode(array("message" => "Não foi possível criar o pagamento."));
            }
        } else {
            http_response_code(404); // Not Found
            echo json_encode(array("message" => "Condômino não encontrado."));
        }
    }

    // Método para buscar um pagamento pelo ID
    public function getPagamento($id) {
        $pagamento = $this->pagamentoDAO->getById($id);

        if ($pagamento) {
            http_response_code(200); // OK
            echo json_encode($pagamento);
        } else {
            http_response_code(404); // Not found
            echo json_encode(array("message" => "Pagamento não encontrado."));
        }
    }

    // Método para atualizar um pagamento
    public function updatePagamento($data) {
        // Validar os dados recebidos, se necessário
        // Exemplo: Verificar se todos os campos obrigatórios estão presentes

        if (!isset($data->id) || !isset($data->data) || !isset($data->valor) || !isset($data->tipo) || !isset($data->condomino_id)) {
            http_response_code(400); // Bad request
            echo json_encode(array("message" => "Erro: Todos os campos (id, data, valor, tipo, condomino_id) são obrigatórios."));
            return;
        }

        // Verificar se o pagamento existe antes de atualizar
        $pagamentoExistente = $this->pagamentoDAO->getById($data->id);
        if (!$pagamentoExistente) {
            http_response_code(404); // Not found
            echo json_encode(array("message" => "Pagamento não encontrado."));
            return;
        }

        // Criar um objeto PagamentoDTO com os dados recebidos
        $pagamento = new PagamentoDTO();
        $pagamento->setId($data->id);
        $pagamento->setData($data->data);
        $pagamento->setValor($data->valor);
        $pagamento->setTipo($data->tipo);
        $pagamento->setCondominoId($data->condomino_id);

        try {
            $this->pagamentoDAO->condominioExiste($data->condominio_id);
            if ($this->pagamentoDAO->update($pagamento)) {
                http_response_code(200);
                echo json_encode(array("message" => "Balancete atualizado com sucesso."));
            } else {
                http_response_code(503);
                echo json_encode(array("message" => "Não foi possível atualizar o balancete."));
            }
        } catch (CondominioNotFoundException $e) {
            http_response_code(404);
            echo json_encode(array("message" => $e->getMessage()));
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(array("message" => "Erro ao atualizar balancete."));
        }
    }

    // Método para deletar um pagamento
    public function deletePagamento($id) {
        // Verificar se o pagamento existe antes de deletar
        $pagamentoExistente = $this->pagamentoDAO->getById($id);
        if (!$pagamentoExistente) {
            http_response_code(404); // Not found
            echo json_encode(array("message" => "Pagamento não encontrado."));
            return;
        }

        // Chamar o método do DAO para deletar o pagamento do banco de dados
        if ($this->pagamentoDAO->delete($id)) {
            http_response_code(200); // OK
            echo json_encode(array("message" => "Pagamento deletado com sucesso."));
        } else {
            http_response_code(503); // Service unavailable
            echo json_encode(array("message" => "Erro ao deletar o pagamento."));
        }
    }

    // Método para obter todos os pagamentos
    public function getAllPagamentos() {
        $pagamentos = $this->pagamentoDAO->getAll();

        if ($pagamentos) {
            http_response_code(200); // OK
            echo json_encode($pagamentos);
        } else {
            http_response_code(404); // Not found
            echo json_encode(array("message" => "Nenhum pagamento encontrado."));
        }
    }
}
?>
