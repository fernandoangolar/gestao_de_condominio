<?php
// UnidadeController.php

include_once('../models/DAO/UnidadeDAO.php');
include_once('../models/DTO/UnidadeDTO.php');

class UnidadeController {
    private $db;
    private $unidadeDAO;

    public function __construct($db) {
        $this->db = $db;
        $this->unidadeDAO = new UnidadeDAO($db);
    }

    // Método para criar uma nova unidade
    public function createUnidade($data) {
        // Validar os dados recebidos, se necessário

        // Criar objeto DTO com os dados recebidos
        $unidadeDTO = new UnidadeDTO();
        $unidadeDTO->setNumero($data->numero);
        $unidadeDTO->setArea($data->area);
        $unidadeDTO->setCondominioId($data->condominio_id);

        // Chamar método do DAO para criar a unidade
        if ($this->unidadeDAO->create($unidadeDTO)) {
            http_response_code(201);
            echo json_encode(array("message" => "Unidade criada com sucesso."));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "Não foi possível criar a unidade."));
        }
    }

    // Método para obter uma unidade pelo ID
    public function getUnidade($id) {
        $unidade = $this->unidadeDAO->getById($id);

        if ($unidade) {
            http_response_code(200);
            echo json_encode($unidade);
        } else {
            http_response_code(404);
            echo json_encode(array("message" => "Unidade não encontrada."));
        }
    }

    // Método para atualizar uma unidade pelo ID
    public function updateUnidade($id, $data) {
         // Verifica se o ID foi passado corretamente
        if (!isset($id)) {
            http_response_code(400);
            echo json_encode(array("message" => "ID não especificado."));
            return;
        }

        // Instancia o UnidadeDTO e atribui os valores recebidos
        $unidadeDTO = new UnidadeDTO();
        $unidadeDTO->setId($id); // Define o ID da unidade

        // Verifica se os dados foram passados corretamente
        if (!isset($data->numero) || !isset($data->condominio_id) || !isset($data->area)) {
            http_response_code(400);
            echo json_encode(array("message" => "Dados incompletos."));
            return;
        }

        // Atribui os dados ao UnidadeDTO
        $unidadeDTO->setNumero($data->numero);
        $unidadeDTO->setCondominioId($data->condominio_id);
        $unidadeDTO->setArea($data->area);

        // Chama o UnidadeDAO para atualizar a unidade
        $result = $this->unidadeDAO->update($unidadeDTO);

        if ($result) {
            http_response_code(200);
            echo json_encode(array("message" => "Unidade atualizada com sucesso."));
        } else {
            http_response_code(500);
            echo json_encode(array("message" => "Erro ao atualizar a unidade."));
        }
    }

    // Método para deletar uma unidade pelo ID
    public function deleteUnidade($id) {
        // Verificar se a unidade existe antes de tentar deletar
        $existingUnidade = $this->unidadeDAO->getById($id);

        if (!$existingUnidade) {
            http_response_code(404);
            echo json_encode(array("message" => "Unidade não encontrada."));
            return;
        }

        // Chamar método do DAO para deletar a unidade
        if ($this->unidadeDAO->delete($id)) {
            http_response_code(200);
            echo json_encode(array("message" => "Unidade deletada com sucesso."));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "Não foi possível deletar a unidade."));
        }
    }

    // Método para buscar todas as unidades
    public function getAllUnidades() {
        $units = $this->unidadeDAO->getAll(); // Assume que o método getAll() está implementado no DAO
        header('Content-Type: application/json');
        echo json_encode($units);
    }
}
?>
