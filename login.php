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

// 4. Verifica se o formulário foi enviado para processar o login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $senha = trim($_POST['senha'] ?? '');

    if (empty($email) || empty($senha)) {
        $mensagem = "Por favor, preencha todos os campos.";
    } else {

        // 5. Busca o usuário no banco de dados pelo email usando uma query preparada para evitar SQL Injection
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        

        // 6. Verifica se o usuário existe e se a senha está correta usando password_verify para comparar a senha digitada com o hash armazenado no banco
        if ($usuario && password_verify($senha, $usuario['senha'])) {
            // Login bem-sucedido; salva o ID na sessão e redireciona
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['logado'] = true;
            
            header("Location: homepage.html"); // Mude para a página desejada após o login
            exit;
        } else {
            $mensagem = "E-mail ou senha incorretos.";
        }
    }
}
?>