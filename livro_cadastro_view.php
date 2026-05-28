<?php
    include 'conexao_bd.php';
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
    
    <?php if (!empty($mensagem)): ?>
        <div class="msg"><?php echo $mensagem; ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label>Título do Livro:</label>
            <input type="text" name="titulo" required value="<?php echo htmlspecialchars($titulo ?? ''); ?>">
        </div>

        <div class="form-group">
            <label>Preço (R$):</label>
            <input type="text" name="preco" placeholder="0.00" value="<?php echo htmlspecialchars($preco ?? ''); ?>">
        </div>

        <div class="form-group">
            <label>Categoria:</label>
            <select name="categoria" required onchange="toggleCategoria()">
                <option value="">Selecione...</option>
                <option value="Gibi" id="gibi">Gibi</option>
                <option value="Livro" id="livro">Livro</option>
                <option value="Didático" id="didatico">Didático</option>
                <option value="Revista" id="revista">Revista</option>
            </select>
        </div>

        <div class="form-group" id="div_gibi_livro" style="display: none; margin-top: 10px;">
            <label>Gênero (Gibi/Livro):</label>
            <select name="genero1">
                <option value="">Selecione...</option>
                <option value="Mistério">Mistério</option>
                <option value="Ficção Científica">Ficção Científica</option>
                <option value="Ação">Ação</option>
                <option value="Medieval">Medieval</option>
            </select>
        </div>

        <div class="form-group" id="div_didatico" style="display: none; margin-top: 10px;">
            <label>Gênero (Didático):</label>
            <select name="genero2">
                <option value="">Selecione...</option>
                <option value="Matemática">Matemática</option>
                <option value="Física">Física</option>
                <option value="Ciências">Ciências</option>
                <option value="Geografia">Geografia</option>
            </select>
        </div>

        <div class="form-group" id="div_revista" style="display: none; margin-top: 10px;">
            <label>Gênero (Revista):</label>
            <select name="genero3">
                <option value="">Selecione...</option>
                <option value="Lazer">Lazer</option>
                <option value="Esportes">Esportes</option>
                <option value="Moda">Moda</option>
                <option value="Geral">Geral</option>
            </select>
        </div>

        <div class="form-group">
            <label>Condição:</label>
            <select name="condicao" required>
                <option value="">Selecione...</option>
                <option value="Novo">Novo</option>
                <option value="Seminovo">Seminovo</option>
                <option value="Bom estado">Bom estado</option>
                <option value="Com marcas de uso">Com marcas de uso</option>
                <option value="Danificado">Danificado</option>
            </select>
        </div>
        <script src="livro_cadastro.js"></script>
        <button type="submit">Salvar Livro</button>
    </form>
    <br>
    <a href="homepage_view.php">Voltar para página principal</a>
</div>

</body>
</html>
