<?php
include_once __DIR__ . '/../models/DAO/UserDAO.php';

class AuthController {
    private $userDao;

    public function __construct() {
        $db = new Database();
        $this->userDao = new UserDAO($db->getConnection());
    }

    public function login() {
        // Leia os dados da requisição
        $data = json_decode(file_get_contents('php://input'), true);
        $email = $data['email'];
        $password = $data['password'];

        $user = $this->userDao->findByEmail($email);

        if ($user && password_verify($password, $user['password_hash'])) {
            // Lógica de redirecionamento baseado no papel do usuário
            echo json_encode([
                'message' => 'Login bem-sucedido.',
                'role' => $user['role']
            ]);
        } else {
            echo json_encode(['message' => 'Email ou senha inválidos.']);
        }
    }
}
?>
