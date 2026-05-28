<?php
// 1. Inicia a sessão para manter o usuário logado
session_start();

// 2. Configurações de conexão com o banco de dados
$host = 'localhost';
$nome_bd = 'livr_ar';
$usuario_bd = 'root';
$senha_bd = '';

$mensagem = '';

// 3. Conexão com o banco de dados usando PDO e tratamento de erros
try {
    $pdo = new PDO("mysql:host=$host;dbname=$nome_bd;charset=utf8", $usuario_bd, $senha_bd);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    error_log("Erro de conexão com o banco de dados: " . $e->getMessage());
    die("Erro de conexão: " . $e->getMessage());
}
?>