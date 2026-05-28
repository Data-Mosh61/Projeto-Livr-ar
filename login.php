<?php
// 1. Verifica se o formulário foi enviado para processar o login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $senha = trim($_POST['senha'] ?? '');

    if (empty($email) || empty($senha)) {
        $mensagem = "Por favor, preencha todos os campos.";
    } else {

        // 2. Busca o usuário no banco de dados pelo email usando uma query preparada para evitar SQL Injection
        $stmt = $pdo->prepare("SELECT * FROM usuarios
                               WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        

        // 3. Verifica se o usuário existe e se a senha está correta usando password_verify para comparar a senha digitada com o hash armazenado no banco
        if ($usuario && password_verify($senha, $usuario['senha'])) {
            // 4. Login bem-sucedido; gere uma nova sessão, salva o ID na sessão e redireciona
            session_regenerate_id(true);

            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['logado'] = true;
            
            header("Location: homepage_view.php"); // 5. Mude para a página desejada após o login
            exit;
        } else {
            $mensagem = "E-mail ou senha incorretos.";
        }
    }
}
?>
