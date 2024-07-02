<?php
// CondominoController.php

include_once '../models/DTO/CodominoDTO.php';
include_once '../models/DAO/CondominoDAO.php';

class CondominoController {
    private $condominoDAO;

    public function __construct() {
        $this->condominoDAO = new CondominoDAO();
    }

    public function createCondomino($data) {
        $condominoDTO = new CondominoDTO();
        $condominoDTO->setUserId($data->user_id); // Certifique-se de que 'user_id' é o campo correto no JSON recebido
        $condominoDTO->setUnidadeId($data->unidade_id); // Certifique-se de que 'unidade_id' é o campo correto no JSON recebido
        $condominoDTO->setStatus($data->status); // Certifique-se de que 'status' é o campo correto no JSON recebido

        $result = $this->condominoDAO->create($condominoDTO);

        if ($result) {
            echo json_encode(array("message" => "Condomino criado com sucesso."));
        } else {
            http_response_code(500);
            echo json_encode(array("message" => "Não foi possível criar o condomino."));
        }
    }

    public function getCondomino($id) {
        $condomino = $this->condominoDAO->getById($id);

        if ($condomino) {
            echo json_encode($condomino);
        } else {
            http_response_code(404);
            echo json_encode(array("message" => "Condomino não encontrado."));
        }
    }

    public function updateCondomino($id, $data) {
        $condominoDTO = new CondominoDTO();
        $condominoDTO->setId($id); // Define o ID do condomino que está sendo atualizado
        $condominoDTO->setUserId($data->user_id); // Certifique-se de que 'user_id' é o campo correto no JSON recebido
        $condominoDTO->setUnidadeId($data->unidade_id); // Certifique-se de que 'unidade_id' é o campo correto no JSON recebido
        $condominoDTO->setStatus($data->status); // Certifique-se de que 'status' é o campo correto no JSON recebido

        $result = $this->condominoDAO->update($condominoDTO);

        if ($result) {
            echo json_encode(array("message" => "Condomino atualizado com sucesso."));
        } else {
            http_response_code(500);
            echo json_encode(array("message" => "Não foi possível atualizar o condomino."));
        }
    }

    public function deleteCondomino($id) {
        $result = $this->condominoDAO->delete($id);

        if ($result) {
            echo json_encode(array("message" => "Condomino deletado com sucesso."));
        } else {
            http_response_code(500);
            echo json_encode(array("message" => "Não foi possível deletar o condomino."));
        }
    }
}
?>
