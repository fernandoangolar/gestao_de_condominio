<?php
include_once '../models/DAO/PrestadorServicoDAO.php';
include_once '../models/DTO/PrestadorServicoDTO.php';

class PrestadorServicoController {
    private $prestadorDAO;

    public function __construct($db) {
        $this->prestadorDAO = new PrestadorServicoDAO($db);
    }

    public function createPrestador($data) {
        $prestador = new PrestadorServicoDTO();
        $prestador->setUserId($data->user_id);
        $prestador->setTipoServico($data->tipo_servico);
        $prestador->setEmpresaNome($data->empresa_nome);

        if (!$this->prestadorDAO->validateUserId($data->user_id)) {
            http_response_code(400);
            echo json_encode(array("message" => "Erro: ID de usuário inválido."));
            return;
        }

        if ($this->prestadorDAO->create($prestador)) {
            http_response_code(201);
            echo json_encode(array("message" => "Prestador de serviço criado com sucesso."));
        } else {
            http_response_code(500);
            echo json_encode(array("message" => "Erro ao criar prestador de serviço."));
        }
    }

    public function getPrestador($id) {
        $result = $this->prestadorDAO->read($id);
        if ($result) {
            http_response_code(200);
            echo json_encode($result);
        } else {
            http_response_code(404);
            echo json_encode(array("message" => "Prestador de serviço não encontrado."));
        }
    }

    public function updatePrestador($id, $data) {
        $prestador = new PrestadorServicoDTO();
        $prestador->setId($id);
        $prestador->setUserId($data->user_id);
        $prestador->setTipoServico($data->tipo_servico);
        $prestador->setEmpresaNome($data->empresa_nome);

        if (!$this->prestadorDAO->validateUserId($data->user_id)) {
            http_response_code(400);
            echo json_encode(array("message" => "Erro: ID de usuário inválido."));
            return;
        }

        if ($this->prestadorDAO->update($prestador)) {
            http_response_code(200);
            echo json_encode(array("message" => "Prestador de serviço atualizado com sucesso."));
        } else {
            http_response_code(500);
            echo json_encode(array("message" => "Erro ao atualizar prestador de serviço."));
        }
    }

    public function deletePrestadorServico($id) {
        if (!$this->prestadorDAO->delete($id)) {
            http_response_code(404); // Not Found
            echo json_encode(array("message" => "ID não encontrado."));
            return;
        }

        http_response_code(200); // OK
        echo json_encode(array("message" => "Prestador de serviço excluído com sucesso."));
    }
}
?>
