<?php
    include 'conexao_bd.php';
    include 'login.php'; 
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
    <title>Login</title>
</head>

<body>
    <div class="container">
        <h2>Entrar</h2>
        
        <?php if (!empty($mensagem)): ?>
            <div class="erro"><?php echo htmlspecialchars($mensagem); ?></div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" required value="<?php echo htmlspecialchars($email ?? ''); ?>">
            </div>
            <div class="form-group">
                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" required>
            </div>
            <button type="submit">Login</button>
        </form>
        
        <p></p>
        <a href="usuario_cadastro_view.php">Ainda não tem uma conta? Clique aqui</a>
    </div>

</body>
</html>