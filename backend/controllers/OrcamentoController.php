<?php
// OrcamentoController.php

require_once '../models/DTO/OrcamentoDTO.php';
require_once '../models/DAO/OrcamentoDAO.php';

class OrcamentoController {
    private $orcamentoDAO;

    public function __construct($db) {
        $this->orcamentoDAO = new OrcamentoDAO($db);
    }

    // Criar um novo orçamento
    public function createOrcamento($data) {
        // Verificar se todos os campos necessários estão presentes
        if (!isset($data->ano) || !isset($data->previsaoReceitas) || !isset($data->previsaoDespesas) || !isset($data->condominio_id)) {
            http_response_code(400);
            echo json_encode(["message" => "Todos os campos (ano, previsaoReceitas, previsaoDespesas, condominio_id) são obrigatórios."]);
            return;
        }

        // Criar um objeto OrcamentoDTO com os dados recebidos
        $orcamento = new OrcamentoDTO();
        $orcamento->setAno($data->ano);
        $orcamento->setPrevisaoReceitas($data->previsaoReceitas);
        $orcamento->setPrevisaoDespesas($data->previsaoDespesas);
        $orcamento->setCondominioId($data->condominio_id);

        // Tentar criar o orçamento usando o DAO
        try {
            if ($this->orcamentoDAO->create($orcamento)) {
                http_response_code(201); // Created
                echo json_encode(["message" => "Orçamento criado com sucesso."]);
            } else {
                http_response_code(503); // Service unavailable
                echo json_encode(["message" => "Não foi possível criar o orçamento."]);
            }
        } catch (Exception $e) {
            http_response_code(500); // Internal server error
            echo json_encode(["message" => "Erro ao criar orçamento: " . $e->getMessage()]);
        }
    }

    public function getOrcamento($id) {
        $result = $this->orcamentoDAO->getById($id);
        if ($result) {
            echo json_encode($result);
        } else {
            echo json_encode(array("message" => "Orçcamento não encontrado."));
        }
    }

    // Atualizar um orçamento existente
    public function updateOrcamento($id, $data) {
        
        $orcamento = $this->orcamentoDAO->getById($id);
        if (!$orcamento) {
            http_response_code(404); // Not found
            echo json_encode(["message" => "Orcamento não encontrado."]);
            return;
        }


        // Criar um objeto OrcamentoDTO com os dados recebidos
        $orcamento = new OrcamentoDTO();
        $orcamento->setId($id);
        $orcamento->setAno($data->ano);
        $orcamento->setPrevisaoReceitas($data->previsaoReceitas);
        $orcamento->setPrevisaoDespesas($data->previsaoDespesas);
        $orcamento->setCondominioId($data->condominio_id);

        // Tentar atualizar o orçamento usando o DAO
        try {
            if ($this->orcamentoDAO->update($orcamento)) {
                http_response_code(200); // OK
                echo json_encode(["message" => "Orçamento atualizado com sucesso."]);
            } else {
                http_response_code(503); // Service unavailable
                echo json_encode(["message" => "Não foi possível atualizar o orçamento."]);
            }
        } catch (Exception $e) {
            http_response_code(500); // Internal server error
            echo json_encode(["message" => "Erro ao atualizar orçamento: " . $e->getMessage()]);
        }
    }

    // Deletar um orçamento pelo ID
    public function deleteOrcamento($id) {
        // Verificar se o orçamento existe antes de deletar
        $orcamentoExistente = $this->orcamentoDAO->getById($id);
        if (!$orcamentoExistente) {
            http_response_code(404); // Not found
            echo json_encode(["message" => "Orçamento não encontrado."]);
            return;
        }

        // Tentar deletar o orçamento usando o DAO
        try {
            if ($this->orcamentoDAO->delete($id)) {
                http_response_code(200); // OK
                echo json_encode(["message" => "Orçamento deletado com sucesso."]);
            } else {
                http_response_code(503); // Service unavailable
                echo json_encode(["message" => "Erro ao deletar o orçamento."]);
            }
        } catch (Exception $e) {
            http_response_code(500); // Internal server error
            echo json_encode(["message" => "Erro ao deletar orçamento: " . $e->getMessage()]);
        }
    }
}
?>
