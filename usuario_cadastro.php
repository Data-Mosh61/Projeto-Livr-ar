<?php

// 1. Configurações de conexão com o banco de dados
$host = 'localhost';
$nome_bd = 'livr_ar';
$usuario_bd = 'root';
$senha_bd = '';

$mensagem = '';

// 2. Tenta conectar ao banco
try {

    // 3. Configura o PDO para lançar exceções em caso de erros
    $pdo = new PDO("mysql:host=$host;dbname=$nome_bd;charset=utf8", $usuario_bd, $senha_bd);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 4. Verifica se o formulário foi enviado
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // 5. Coleta os dados do formulário
        $nome = trim($_POST['nome']);
        $email = trim($_POST['email']);
        $senha = $_POST['senha'];
        $estado = trim($_POST['estado']);
        $telefone = trim($_POST['telefone']);
        
        // 6. Por telefone ser opcional, se estiver vazio, envia NULL para o banco.
        if (empty($telefone)) {
            $telefone = null;
        }

        // 7. Validação básica para garantir que os campos obrigatórios não estão vazios
        if (!empty($nome) && !empty($email) && !empty($senha) && !empty($estado)) {
            
            // 8. Cria o hash seguro da senha
            $senha_criptografada = password_hash($senha, PASSWORD_DEFAULT);

            // 9. Prepara a query de inserção para evitar "SQL Injection"
            $sql = "INSERT INTO usuarios (nome, email, senha, estado, telefone) 
                    VALUES (:nome, :email, :senha, :estado, :telefone)";
            $stmt = $pdo->prepare($sql);

            // 10. Executa a query substituindo os parâmetros com segurança
            try {
                $stmt->execute([
                    ':nome' => $nome,
                    ':email' => $email,
                    ':senha' => $senha_criptografada,
                    ':estado' => $estado,
                    ':telefone' => $telefone
                ]);
                $mensagem = "<p style='color: green;'>Usuário cadastrado com sucesso!</p>";
            } catch (PDOException $e) {

                // 11. O código de erro 23000 no MySQL indica que uma restrição UNIQUE foi violada (ex: email já existe)
                if ($e->getCode() == 23000) {
                    $mensagem = "<p style='color: red;'>ERRO: Este e-mail já está cadastrado.</p>";
                } else {
                    $mensagem = "<p style='color: red;'>Erro ao cadastrar: " . $e->getMessage() . "</p>";
                }
            }
        } else {
            $mensagem = "<p style='color: orange;'>Por favor, preencha todos os campos obrigatórios.</p>";
        }
    }
} catch (PDOException $e) {
    $mensagem = "<p style='color: red;'>Erro de conexão com o banco de dados: " . $e->getMessage() . "</p>";
}
?>