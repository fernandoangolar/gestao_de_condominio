<?php
// RelatorioContasController.php

include_once '../models/DAO/RelatorioContasDAO.php';

class RelatorioContasController {
    private $relatorioContasDAO;

    public function __construct($db) {
        $this->relatorioContasDAO = new RelatorioContasDAO($db);
    }

    // Cria um relatório de contas
    public function createRelatorioContas($data) {

        // Verificar se todos os campos obrigatórios estão presentes
    if (!isset($data->ano) || !isset($data->receitas) || !isset($data->despesas) || !isset($data->condominio_id)) {
        http_response_code(400); // Bad request
        echo json_encode(["message" => "Dados incompletos para criar o relatório de contas."]);
        return;
    }

        $relatorio = new RelatorioContasDTO();
        $relatorio->setAno($data->ano);
        $relatorio->setReceitas($data->receitas);
        $relatorio->setDespesas($data->despesas);
        $relatorio->setCondominioId($data->condominio_id);

        if ($this->relatorioContasDAO->create($relatorio)) {
            echo json_encode(array("message" => "Relatório de contas criado com sucesso."));
        } else {
            echo json_encode(array("message" => "Não foi possível criar o relatório de contas."));
        }
    }

    // Obtém um relatório de contas por ID
    public function getRelatorioContas($id) {
        $result = $this->relatorioContasDAO->getById($id);
        if ($result) {
            echo json_encode($result);
        } else {
            echo json_encode(array("message" => "Relatório de contas não encontrado."));
        }
    }

    public function updateRelatorioContas($id, $data) {

        $relatorioExistente = $this->relatorioContasDAO->getById($id);
        if (!$relatorioExistente) {
            http_response_code(404); // Not found
            echo json_encode(["message" => "Relatório de contas não encontrado."]);
            return;
        }
    
        // Criar um objeto RelatorioContasDTO com os dados recebidos
        $relatorio = new RelatorioContasDTO();
        $relatorio->setId($id); // Definir o ID do relatório de contas a ser atualizado
        $relatorio->setAno($data->ano);
        $relatorio->setReceitas($data->receitas);
        $relatorio->setDespesas($data->despesas);
        $relatorio->setCondominioId($data->condominio_id);
    
            // Atualiza o relatório de contas
        if ($this->relatorioContasDAO->update($relatorio)) {
            http_response_code(200); // OK
            echo json_encode(["message" => "Relatório de contas atualizado com sucesso."]);
        } else {
            http_response_code(503); // Service Unavailable
            echo json_encode(["message" => "Erro ao atualizar o relatório de contas."]);
        }
    }

    // Deleta um relatório de contas por ID
    public function deleteRelatorioContas($id) {
        // Verificar se o pagamento existe antes de deletar
        $relatorioExistente = $this->relatorioContasDAO->getById($id);
        if (!$relatorioExistente) {
            http_response_code(404); // Not found
            echo json_encode(array("message" => "Relatorio de contas não encontrado."));
            return;
        }

        // Chamar o método do DAO para deletar o pagamento do banco de dados
        if ($this->relatorioContasDAO->delete($id)) {
            http_response_code(200); // OK
            echo json_encode(array("message" => "Relatorio de contas deletado com sucesso."));
        } else {
            http_response_code(503); // Service unavailable
            echo json_encode(array("message" => "Erro ao deletar o Relatorio de contas."));
        }
    }
}
?>
