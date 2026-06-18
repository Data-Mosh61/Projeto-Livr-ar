<?php
include 'conexao_bd.php';
include 'editar_livro.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Livro</title>
     <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Editar Informações do Livro</h2>

    <div class="form-container">
        <?php if (!empty($mensagem)): ?>
            <div class="msg-sucesso"><?php echo htmlspecialchars($mensagem); ?></div>
        <?php endif; ?>

        <?php if (!empty($erro)): ?>
            <div class="msg-erro"><?php echo htmlspecialchars($erro); ?></div>
        <?php endif; ?>

        <form method="POST" action="editar_livro_view.php">
            <input type="hidden" name="id_livro" value="<?php echo $livro['id_livro']; ?>">

            <div class="form-group">
                <label>Título:</label>
                <input type="text" name="titulo" value="<?php echo htmlspecialchars($livro['titulo']); ?>" required>
            </div>

            <div class="form-group">
                <label>Categoria:</label>
                <select name="categoria" id="categoria" onchange="toggleCategoria()" required>
                    <option value="Gibi" id="gibi" <?php echo ($livro['categoria'] == 'Gibi') ? 'selected' : ''; ?>>Gibi</option>
                    <option value="Livro" id="livro" <?php echo ($livro['categoria'] == 'Livro') ? 'selected' : ''; ?>>Livro</option>
                    <option value="Didático" id="didatico" <?php echo ($livro['categoria'] == 'Didático') ? 'selected' : ''; ?>>Didático</option>
                    <option value="Revista" id="revista" <?php echo ($livro['categoria'] == 'Revista') ? 'selected' : ''; ?>>Revista</option>
                </select>
            </div>

            <div class="form-group" id="div_gibi_livro" style="display: none;">
                <label>Gênero (Gibi/Livro):</label>
                <select name="genero1">
                    <option value="Mistério" <?php echo ($livro['genero'] == 'Mistério') ? 'selected' : ''; ?>>Mistério</option>
                    <option value="Ficção Cientifica" <?php echo ($livro['genero'] == 'Ficção Cientifica') ? 'selected' : ''; ?>>Ficção Científica</option>
                    <option value="Ação" <?php echo ($livro['genero'] == 'Ação') ? 'selected' : ''; ?>>Ação</option>
                    <option value="Medieval" <?php echo ($livro['genero'] == 'Medieval') ? 'selected' : ''; ?>>Medieval</option>
                </select>
            </div>

            <div class="form-group" id="div_didatico" style="display: none;">
                <label>Gênero (Didático):</label>
                <select name="genero2">
                    <option value="Matemática" <?php echo ($livro['genero'] == 'Matemática') ? 'selected' : ''; ?>>Matemática</option>
                    <option value="Física" <?php echo ($livro['genero'] == 'Física') ? 'selected' : ''; ?>>Física</option>
                    <option value="Ciências" <?php echo ($livro['genero'] == 'Ciências') ? 'selected' : ''; ?>>Ciências</option>
                    <option value="Geografia" <?php echo ($livro['genero'] == 'Geografia') ? 'selected' : ''; ?>>Geografia</option>
                </select>
            </div>

            <div class="form-group" id="div_revista" style="display: none;">
                <label>Gênero (Revista):</label>
                <select name="genero3">
                    <option value="Lazer" <?php echo ($livro['genero'] == 'Lazer') ? 'selected' : ''; ?>>Lazer</option>
                    <option value="Esportes" <?php echo ($livro['genero'] == 'Esportes') ? 'selected' : ''; ?>>Esportes</option>
                    <option value="Moda" <?php echo ($livro['genero'] == 'Moda') ? 'selected' : ''; ?>>Moda</option>
                    <option value="Geral" <?php echo ($livro['genero'] == 'Geral') ? 'selected' : ''; ?>>Geral</option>
                </select>
            </div>

            <div class="form-group">
                <label>Preço (R$):</label>
                <input type="text" name="preco" value="<?php echo number_format($livro['preco'], 2, ',', ''); ?>" required>
            </div>

            <div class="form-group">
                <label>Condição:</label>
                <select name="condicao" required>
                    <option value="Novo" <?php echo ($livro['condicao'] == 'Novo') ? 'selected' : ''; ?>>Novo</option>
                    <option value="Seminovo" <?php echo ($livro['condicao'] == 'Seminovo') ? 'selected' : ''; ?>>Seminovo</option>
                    <option value="Bom estado" <?php echo ($livro['condicao'] == 'Bom estado') ? 'selected' : ''; ?>>Bom estado</option>
                    <option value="Com marcas de uso" <?php echo ($livro['condicao'] == 'Com marcas de uso') ? 'selected' : ''; ?>>Com marcas de uso</option>
                    <option value="Danificado" <?php echo ($livro['condicao'] == 'Danificado') ? 'selected' : ''; ?>>Danificado</option>
                </select>
            </div>

            <button type="submit" class="btn-salvar">Salvar Alterações</button>
        </form>
            <script src="editar_livro.js"></script>
        <a href="meus_livros_view.php" class="voltar-link">Voltar para Gerenciamento</a>
    </div>
</body>
</html>