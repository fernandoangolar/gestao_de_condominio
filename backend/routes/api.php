<?php
include_once '../config/db.php';
include_once '../controllers/UserController.php';
include_once('../controllers/UnidadeController.php');
include_once('../controllers/CondominioController.php');
include_once('../controllers/CondominoController.php');
include_once('../controllers/FuncionarioController.php');
include_once '../controllers/PrestadorServicoController.php';
require_once '../controllers/BalanceteController.php';
include_once '../controllers/PagamentoController.php';
include_once '../controllers/OrcamentoController.php';
include_once '../controllers/RelatorioContasController.php';
include_once '../controllers/TarefaManutencaoController.php';

$database = new Database();
$db = $database->getConnection();
$userController = new UserController($db);
$unidadeController = new UnidadeController($db);
$condominioController = new CondominioController($db);
$condominoController = new CondominoController($db);
$funcionarioController = new FuncionarioController($db);
$prestadorController = new PrestadorServicoController($db);
$balanceteController = new BalanceteController($db);
$pagamentoController = new PagamentoController($db);
$orcamentoController = new OrcamentoController($db);
$relatorioContasController = new RelatorioContasController($db);
$tarefaManutencaoController = new TarefaManutencaoController($db);


// Rota base da API
$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        switch ($action) {
            case 'getUser':
                $id = isset($_GET['id']) ? $_GET['id'] : die();
                $userController->getUser($id);
                break;
            case 'getUnidade':
                $id = isset($_GET['id']) ? $_GET['id'] : die();
                $unidadeController->getUnidade($id);
                break;
            case 'getCondominio':
                $id = isset($_GET['id']) ? $_GET['id'] : die();
                $condominioController->getCondominio($id);
                break;
            case 'getCondomino':
                $id = isset($_GET['id']) ? $_GET['id'] : die();
                $condominoController->getCondomino($id);
                break;
            case 'getFuncionario':
                $id = isset($_GET['id']) ? $_GET['id'] : die();
                $funcionarioController->getFuncionario($id);
                break;
            case 'getPrestador':
                $id = isset($_GET['id']) ? $_GET['id'] : null;
                $prestadorController->getPrestador($id);
                break;
            case 'getBalancete':
                $id = isset($_GET['id']) ? $_GET['id'] : null;
                $balanceteController->getBalancete($id);
                break;
            case 'getPagamento':
                $id = isset($_GET['id']) ? $_GET['id'] : null;
                $pagamentoController->getPagamento($id);
                break;
            case 'getRelatorioContas':
                $id = isset($_GET['id']) ? $_GET['id'] : null;
                $relatorioContasController->getRelatorioContas($id);
                break;
            case 'getOrcamento':
                $id = isset($_GET['id']) ? $_GET['id'] : null;
                $orcamentoController->getOrcamento($id);
                break;
            case 'getTarefa':
                $id = isset($_GET['id']) ? $_GET['id'] : null;
                $tarefaManutencaoController->getTarefa($id);
                break;
            case 'getAllUnidades':
                $unidadeController->getAllUnidades();
                break;
            case 'getAllCondominioNames':
                $condominioController->getAllCondominioNames();
                break;
            case 'getAllCondominios':
                $condominioController->getAllCondominios();
                break;
            default:
                http_response_code(404);
                echo json_encode(array("message" => "Rota GET não encontrada."));
                break;
        }
        break;
    case 'POST':
        switch ($action) {
            case 'createUser':
                $data = json_decode(file_get_contents("php://input"));
                $userController->createUser($data);
                break;
            case 'createUnidade':
                $data = json_decode(file_get_contents("php://input"));
                $unidadeController->createUnidade($data);
                break;
            case 'createCondominio':
                $data = json_decode(file_get_contents("php://input"));
                $condominioController->createCondominio($data);
                break;
            case 'createCondomino':
                $data = json_decode(file_get_contents("php://input"));
                $condominoController->createCondomino($data);
                break;
            case 'createFuncionario':
                $data = json_decode(file_get_contents("php://input"));
                $funcionarioController->createFuncionario($data);
                break;
            case 'createPrestador':
                $data = json_decode(file_get_contents("php://input"));
                $prestadorController->createPrestador($data);
            case 'createBalancete':
                $data = json_decode(file_get_contents("php://input"));
                $balanceteController->createBalancete($data);
                break;
            case 'createPagamento':
                $data = json_decode(file_get_contents("php://input"));
                $pagamentoController->createPagamento($data);
                break;
            case 'createRelatorioContas':
                $data = json_decode(file_get_contents("php://input"));
                $relatorioContasController->createRelatorioContas($data);
                break;
            case 'createOrcamento':
                $data = json_decode(file_get_contents("php://input"));
                $orcamentoController->createOrcamento($data);
                break;
            case 'createTarefa':
                $data = json_decode(file_get_contents("php://input"));
                $tarefaManutencaoController->createTarefa($data);
                break;
            default:
                http_response_code(404);
                echo json_encode(array("message" => "Rota POST não encontrada."));
                break;
        }
        break;
    case 'PUT':
        switch ($action) {
            case 'updateUser':
                parse_str(file_get_contents("php://input"), $put_vars);
                $id = isset($_GET['id']) ? $_GET['id'] : die();
                $userController->updateUser($id, (object)$put_vars);
                break;
            case 'updateUnidade':
                $data = json_decode(file_get_contents("php://input"));
                $id = isset($_GET['id']) ? $_GET['id'] : die();
                $unidadeController->updateUnidade($id, $data);
                break;
            case 'updateCondominio':
                $id = isset($_GET['id']) ? $_GET['id'] : die();
                $data = json_decode(file_get_contents("php://input"));
                $condominioController->updateCondominio($id, $data);
                break;
            case 'updateCondomino':
                $data = json_decode(file_get_contents("php://input"));
                $id = isset($_GET['id']) ? $_GET['id'] : die();
                $condominoController->updateCondomino($id, $data);
                break;
            case 'updateFuncionario':
                $id = isset($_GET['id']) ? $_GET['id'] : die();
                $data = json_decode(file_get_contents("php://input"));
                $funcionarioController->updateFuncionario($id, $data);
                break;
            case 'updatePrestador':
                $data = json_decode(file_get_contents("php://input"));
                $id = isset($_GET['id']) ? $_GET['id'] : die();
                $prestadorController->updatePrestador($id, $data);
                break;
            case 'updateBalancete':
                $id = isset($_GET['id']) ? $_GET['id'] : die();
                $data = json_decode(file_get_contents("php://input"));
                $balanceteController->updateBalancete($id, $data);
                break;
            case 'updatePagamento':
                $id = isset($_GET['id']) ? $_GET['id'] : die();
                $data = json_decode(file_get_contents("php://input"));
                $pagamentoController->updatePagamento($id, $data);
                break;
            case 'updateRelatorioContas':
                $id = isset($_GET['id']) ? $_GET['id'] : die();
                $data = json_decode(file_get_contents("php://input"));
                $relatorioContasController->updateRelatorioContas($id, $data);
                break;
            case 'updateOrcamento':
                $id = isset($_GET['id']) ? $_GET['id'] : die();
                $data = json_decode(file_get_contents("php://input"));
                $orcamentoController->updateOrcamento($id, $data);
                break;
            case 'updateTarefa':
                $id = isset($_GET['id']) ? $_GET['id'] : die();
                $data = json_decode(file_get_contents("php://input"));
                $tarefaManutencaoController->updateTarefa($id, $data);
                break;
            default:
                http_response_code(404);
                echo json_encode(array("message" => "Rota PUT não encontrada."));
                break;
        }
        break;
    case 'DELETE':
        switch ($action) {
            case 'deleteUser':
                $id = isset($_GET['id']) ? $_GET['id'] : die();
                $userController->deleteUser($id);
                break;
            case 'deleteUnidade':
                $id = isset($_GET['id']) ? $_GET['id'] : die();
                $unidadeController->deleteUnidade($id);
                break;
            case 'deleteCondominio':
                $id = isset($_GET['id']) ? $_GET['id'] : die();
                $condominioController->deleteCondominio($id);
                break;
            case 'deleteCondomino':
                $id = isset($_GET['id']) ? $_GET['id'] : die();
                $condominoController->deleteCondomino($id);
                break;
            case 'deleteFuncionario':
                $id = isset($_GET['id']) ? $_GET['id'] : die();
                $funcionarioController->deleteFuncionario($id);
                break;
            case 'deletePrestador':
                $id = isset($_GET['id']) ? $_GET['id'] : die();
                $prestadorController->deletePrestadorServico($id);
                break;
            case 'deleteBalancete':
                $id = isset($_GET['id']) ? $_GET['id'] : die();
                $balanceteController->deleteBalancete($id);
                break;
            case 'deletePagamento':
                $id = isset($_GET['id']) ? $_GET['id'] : die();
                $pagamentoController->deletePagamento($id);
                break;
            case 'deleteRelatorioContas':
                $id = isset($_GET['id']) ? $_GET['id'] : null;
                $relatorioContasController->deleteRelatorioContas($id);
                break;
            case 'deleteOrcamento':
                $id = isset($_GET['id']) ? $_GET['id'] : null;
                $orcamentoController->deleteOrcamento($id);
                break;
            case 'deleteTarefa':
                $id = isset($_GET['id']) ? $_GET['id'] : null;
                $tarefaManutencaoController->deleteTarefa($id);
                break;
            default:
                http_response_code(404);
                echo json_encode(array("message" => "Rota DELETE não encontrada."));
                break;
        }
        break;
    default:
        http_response_code(405);
        echo json_encode(array("message" => "Método HTTP não permitido."));
        break;
}
?>

