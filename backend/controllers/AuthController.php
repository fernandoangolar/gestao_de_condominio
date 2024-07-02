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
       $email = $data['email'] ?? '';
       $password = $data['password'] ?? '';

       // Verifique se os campos estão preenchidos
       if (empty($email) || empty($password)) {
           echo json_encode(['message' => 'Email ou senha não fornecidos.']);
           return;
       }

       // Buscar o usuário pelo email
       $user = $this->userDao->findByEmail($email);

       // Verificar se o usuário existe
       if ($user) {
           // Verificar a senha
           if (password_verify($password, $user['password_hash'])) {
               echo json_encode([
                   'message' => 'Login bem-sucedido.',
                   'role' => $user['role'],
                   'id' => $user['id']
               ]);
               return;
           } else {
               echo json_encode(['message' => 'Senha inválida.']);
               return;
           }
       } else {
           echo json_encode(['message' => 'Email não encontrado.']);
           return;
       }
    }
}
?>
