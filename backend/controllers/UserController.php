<?php

include_once '../config/db.php';
include_once '../models/DAO/UserDAO.php';
include_once '../models/DTO/UseDTO.php';

class UserController {
    private $userDAO;

    public function __construct($db) {
        $this->userDAO = new UserDAO($db);
    }

    // Criar um novo usuário
    public function createUser($data) {
        $user = new UserDTO(
            null,
            $data->username,
            $data->password_hash,
            $data->role,
            $data->email,
            $data->nome,
            $data->contato
        );

        if ($this->userDAO->create($user)) {
            echo json_encode(array("message" => "Usuário criado com sucesso."));
        } else {
            echo json_encode(array("message" => "Não foi possível criar o usuário."));
        }
    }

    // Ler dados de um usuário específico
    public function getUser($id) {
        $user = $this->userDAO->read($id);

        if ($user) {
            echo json_encode($user);
        } else {
            echo json_encode(array("message" => "Usuário não encontrado."));
        }
    }

    // Atualizar um usuário existente
    public function updateUser($id, $data) {
        $user = $this->userDAO->read($id);

        if (!$user) {
            echo json_encode(array("message" => "Usuário não encontrado."));
            return;
        }

        // Atualizar usuário
        $updatedUser = new UserDTO(
            $id,
            $data->username,
            $data->password_hash,
            $data->role,
            $data->email,
            $data->nome,
            $data->contato
        );

        if ($this->userDAO->update($updatedUser)) {
            echo json_encode(array("message" => "Usuário atualizado com sucesso."));
        } else {
            echo json_encode(array("message" => "Não foi possível atualizar o usuário."));
        }
    }

    // Deletar um usuário existente
    public function deleteUser($id) {
        $user = $this->userDAO->read($id);

        if (!$user) {
            echo json_encode(array("message" => "Usuário não encontrado."));
            return;
        }

        if ($this->userDAO->delete($id)) {
            echo json_encode(array("message" => "Usuário deletado com sucesso."));
        } else {
            echo json_encode(array("message" => "Não foi possível deletar o usuário."));
        }
    }
}
?>
