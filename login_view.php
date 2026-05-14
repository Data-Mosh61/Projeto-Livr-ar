<?php 
    include 'login.php'; 
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Login</title>
</head>

<body>
    <div class="login-container">
        <h2>Entrar</h2>
        
        <!-- Displays the error message from login.php if it exists -->
        <?php if (!empty($mensagem)): ?>
            <div class="erro"><?php echo htmlspecialchars($mensagem); ?></div>
        <?php endif; ?>
        
        <!-- Fixed: Removed extra quotes in method, removed action so it posts to itself -->
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
        <a href="cadastro.html">Ainda não tem uma conta? Clique aqui</a>
    </div>

</body>
</html>