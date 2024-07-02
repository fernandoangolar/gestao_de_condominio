<?php
include_once '../models/DAO/CondominioDAO.php';

class CondominioController {
    private $condominioDAO;

    public function __construct() {
        $this->condominioDAO = new CondominioDAO();
    }

    // Criar um novo condomínio
    public function createCondominio($data) {
        // Validar e usar os dados recebidos para criar um novo condomínio
        $condominioDTO = new CondominioDTO();
        $condominioDTO->setNome($data->nome);       // Verifique se o campo no JSON é 'nome'
        $condominioDTO->setEndereco($data->endereco); // Verifique se o campo no JSON é 'endereco'

        // Chama o DAO para criar o condomínio no banco de dados
        $result = $this->condominioDAO->create($condominioDTO);

        if ($result) {
            echo json_encode(array("message" => "Condomínio criado com sucesso."));
        } else {
            http_response_code(500);
            echo json_encode(array("message" => "Não foi possível criar o condomínio."));
        }
    }

    // Buscar um condomínio pelo ID
    public function getCondominio($id) {
        $condominio = $this->condominioDAO->getById($id);
        if ($condominio) {
            echo json_encode($condominio);
        } else {
            echo json_encode(array("message" => "Condomínio não encontrado."));
        }
    }

    // Atualizar um condomínio pelo ID
    public function updateCondominio($id, $data) {
         // Validar e usar os dados recebidos para atualizar o condomínio
         $condominioDTO = new CondominioDTO();
         $condominioDTO->setId($id); // Define o ID do condomínio que está sendo atualizado
         $condominioDTO->setNome($data->nome);       // Verifique se o campo no JSON é 'nome'
         $condominioDTO->setEndereco($data->endereco); // Verifique se o campo no JSON é 'endereco'

        $result = $this->condominioDAO->update($condominioDTO);

        if ($result) {
            echo json_encode(array("message" => "Condomínio atualizado com sucesso."));
        } else {
            http_response_code(500);
            echo json_encode(array("message" => "Não foi possível atualizar o condomínio."));
        }
    }

    // Deletar um condomínio pelo ID
    public function deleteCondominio($id) {
        if ($this->condominioDAO->delete($id)) {
            echo json_encode(array("message" => "Condomínio deletado com sucesso."));
        } else {
            echo json_encode(array("message" => "Não foi possível deletar o condomínio."));
        }
    }

    public function getAllCondominioNames() {
        $condominioDAO = new CondominioDAO();
        $nomesCondominios = $condominioDAO->getAllNames();

        // Retorna os nomes dos condomínios como JSON
        echo json_encode($nomesCondominios);
    }

    public function getAllCondominios() {
        $condominios = $this->condominioDAO->getAll();

        if ($condominios) {
            http_response_code(200);
            echo json_encode($condominios);
        } else {
            http_response_code(404);
            echo json_encode(array("message" => "Nenhum condomínio encontrado."));
        }
    }
}
?>
