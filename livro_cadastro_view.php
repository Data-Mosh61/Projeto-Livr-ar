<?php
    include 'livro_cadastro.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Livro</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="container">
    <h2>Cadastrar Novo Livro</h2>
    
    <?php if ($mensagem): ?>
        <div class="msg"><?php echo $mensagem; ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label>Título do Livro:</label>
            <input type="text" name="titulo" required>
        </div>

        <div class="form-group">
            <label>Preço (R$):</label>
            <input type="text" name="preco" placeholder="0.00">
        </div>

        <div class="form-group">
            <label>Gênero:</label>
            <select name="genero" required>
                <option value="">Selecione...</option>
                <option value="Mistério">Mistério</option>
                <option value="Ficção Cientifica">Ficção Científica</option>
                <option value="Ação">Ação</option>
                <option value="Medieval">Medieval</option>
            </select>
        </div>

        <div class="form-group">
            <label>Condição:</label>
            <select name="condicao" required>
                <option value="Novo">Novo</option>
                <option value="Seminovo">Seminovo</option>
                <option value="Bom estado">Bom estado</option>
                <option value="Com marcas de uso">Com marcas de uso</option>
                <option value="Danificado">Danificado</option>
            </select>
        </div>

        <button type="submit">Salvar Livro</button>
    </form>
    <br>
    <a href="homepage.html">Voltar para página principal</a>
</div>

</body>
</html>