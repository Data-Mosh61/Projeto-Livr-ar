<?php
    include 'usuario_cadastro.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro do Usuário</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    
    <?php if (isset($mensagem)) echo $mensagem; ?>
    <h2>Criar Nova Conta</h2>

    <form method="POST" action="">
        <div class="form-group">
            <label for="nome">Nome Completo *</label>
            <input type="text" name="nome" id="nome" required>
        </div>

        <div class="form-group">
            <label for="email">E-mail *</label>
            <input type="email" name="email" id="email" required>
        </div>

        <div class="form-group">
            <label for="senha">Senha *</label>
            <input type="password" name="senha" id="senha" required>
        </div>

        <div class="form-group">
            <label for="estado">Estado *</label>
            <select name="estado" required>
                <option value="">Selecione...</option>
                <option value="PR">Paraná</option>
                <option value="SC">Santa Catarina</option>
                <option value="RS">Rio Grande do Sul</option>
                <option value="SP">São Paulo</option>
            </select>
        </div>

        <div class="form-group">
            <label for="telefone">Telefone (Opcional)</label>
            <input type="tel" name="telefone" id="telefone" placeholder="Ex: (00) 00000-0000">
        </div>

        <button type="submit">Cadastrar</button>
    </form>
<a href="login_view.php">Já está cadastrado? Clique aqui</a>
</body>
</html>