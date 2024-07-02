<?php 

include_once './config/db.php';

// Cria uma instância da classe Database
$database = new Database();
$conn = $database->getConnection();

// Verifica se a conexão foi bem-sucedida
if ($conn) {
    echo "Conexão bem-sucedida!";
    // Execute suas consultas ou operações aqui
} else {
    echo "Não foi possível conectar ao banco de dados.";
    // Lida com a falha na conexão aqui
}

?>