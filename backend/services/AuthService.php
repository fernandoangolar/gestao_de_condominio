<?php
class AuthService {
    private $userDAO;

    public function __construct($userDAO) {
        $this->userDAO = $userDAO;
    }

    public function login($userDTO) {
        $user = $this->userDAO->findByEmail($userDTO->getEmail());
        
        if ($user && password_verify($userDTO->getPassword(), $user['password_hash'])) {
            return ['message' => 'Login successful.', 'user' => $user];
        } else {
            return ['message' => 'Invalid email or password.'];
        }
    }
}
?>
