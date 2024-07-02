<?php 
include_once '../models/DAO/BalanceteDAO.php';
include_once '../utils/CondominioNotFoundException.php';
// BalanceteController.php

class BalanceteController {
    private $balanceteDAO;

    public function __construct($db) {
        $this->balanceteDAO = new BalanceteDAO($db);
    }

    public function createBalancete($data) {
        $balancete = new BalanceteDTO();
        $balancete->setData($data->data);
        $balancete->setTotalDespesas($data->totalDespesas);
        $balancete->setTotalReceitas($data->totalReceitas);
        $balancete->setCondominioId($data->condominio_id);

        // Validação se o condominio_id existe
        if ($this->balanceteDAO->condominioExiste($data->condominio_id)) {
            // Tenta criar o balancete
            if ($this->balanceteDAO->create($balancete)) {
                http_response_code(201); // Created
                echo json_encode(array("message" => "Balancete criado com sucesso."));
            } else {
                http_response_code(503); // Service Unavailable
                echo json_encode(array("message" => "Não foi possível criar o balancete."));
            }
        } else {
            http_response_code(400); // Bad Request
            echo json_encode(array("message" => "Condomínio não encontrado."));
        }
    }

    public function getBalancete($id) {
        $balancete = $this->balanceteDAO->getBalancete($id);
        if ($balancete) {
            http_response_code(200);
            echo json_encode(array(
                "data" => $balancete->getData(),
                "totalDespesas" => $balancete->getTotalDespesas(),
                "totalReceitas" => $balancete->getTotalReceitas(),
                "condominio_id" => $balancete->getCondominioId()
            ));
        } else {
            http_response_code(404);
            echo json_encode(array("message" => "Balancete não encontrado."));
        }
    }

    public function updateBalancete($id, $data) {
        // Verifica se o balancete existe
        $balanceteExistente = $this->balanceteDAO->getById($id);
        if (!$balanceteExistente) {
            http_response_code(404); // Not Found
            echo json_encode(array("message" => "Balancete não encontrado."));
            return;
        }

        // Atualiza os dados do balancete
        $balancete = new BalanceteDTO($data->data, $data->totalDespesas, $data->totalReceitas, $data->condominio_id);
        $balancete->setId($id);

        try {
            $this->balanceteDAO->condominioExiste($data->condominio_id);
            if ($this->balanceteDAO->update($balancete)) {
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

        // // Chamada ao DAO para atualizar o balancete
        // if ($this->balanceteDAO->update($balancete)) {
        //     http_response_code(200); // OK
        //     echo json_encode(array("message" => "Balancete atualizado com sucesso."));
        // } else {
        //     http_response_code(503); // Service Unavailable
        //     echo json_encode(array("message" => "Não foi possível atualizar o balancete."));
        // }
    }

    public function deleteBalancete($id) {
        // Verifica se o balancete existe
        $balanceteExistente = $this->balanceteDAO->getById($id);
        if (!$balanceteExistente) {
            http_response_code(404); // Not Found
            echo json_encode(array("message" => "Balancete não encontrado."));
            return;
        }

        // Chamada ao DAO para deletar o balancete
        if ($this->balanceteDAO->delete($id)) {
            http_response_code(200); // OK
            echo json_encode(array("message" => "Balancete excluído com sucesso."));
        } else {
            http_response_code(503); // Service Unavailable
            echo json_encode(array("message" => "Não foi possível excluir o balancete."));
        }
    }
}


?>