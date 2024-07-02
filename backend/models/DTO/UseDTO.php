<?php
class UserDTO {
    public $id;
    public $username;
    public $password_hash;
    public $role;
    public $email;
    public $nome;
    public $contato;

    public function __construct($id, $username, $password_hash, $role, $email, $nome, $contato) {
        $this->id = $id;
        $this->username = $username;
        $this->password_hash = $password_hash;
        $this->role = $role;
        $this->email = $email;
        $this->nome = $nome;
        $this->contato = $contato;
    }
}
?>
