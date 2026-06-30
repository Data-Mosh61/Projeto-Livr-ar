<?php
    include 'conexao_bd.php';
    include 'pesquisa.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Catálogo de Livros</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
    <style>
        body { padding: 0px; margin: 0px;}
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    <?php if (isset($_SESSION['usuario_id']) && $_SESSION['usuario_id'] !== NULL) {
        include 'pendencias.php';
    }?>
    <h2>Catálogo de Livros Disponíveis</h2>
    <h2><?php if (!empty($mensagem)): ?>
            <div class="erro"><?php echo htmlspecialchars($mensagem); ?></div>
    <?php endif; ?></h2>
    <div class="filter-section">
        <form method="GET" class="filter-form">
            <div class="form-group">
                <label>Título:</label>
                <input type="text" name="titulo" value="<?php echo $_GET['titulo'] ?? ''; ?>" style="width:100%; padding:8px;">
            </div>

            <div class="form-group">
                <label>Categoria:</label>
                <select name="categoria" style="width:100%; padding:8px;" onchange="toggleCategoria()">
                    <option value="">Todas</option>
                    <option value="Gibi" id="gibi" <?php echo ($_GET['categoria'] ?? '') == 'Gibi' ? 'selected' : ''; ?>>Gibi</option>
                    <option value="Livro" id="livro" <?php echo ($_GET['categoria'] ?? '') == 'Livro' ? 'selected' : ''; ?>>Livro</option>
                    <option value="Didático" id="didatico" <?php echo ($_GET['categoria'] ?? '') == 'Didático' ? 'selected' : ''; ?>>Didático</option>
                    <option value="Revista" id="revista" <?php echo ($_GET['categoria'] ?? '') == 'Revista' ? 'selected' : ''; ?>>Revista</option>
                </select>
            </div>

            <div class="form-group" id="div_gibi_livro" style="display: none;">
                <label>Gênero (Revista/Gibi):</label>
                <select name="genero1" style="width:100%; padding:8px;">
                    <option value="">Todos</option>
                    <option value="Mistério" <?php echo ($_GET['genero1'] ?? '') == 'Mistério' ? 'selected' : ''; ?>>Mistério</option>
                    <option value="Ficção Cientifica" <?php echo ($_GET['genero1'] ?? '') == 'Ficção Cientifica' ? 'selected' : ''; ?>>Ficção Científica</option>
                    <option value="Ação" <?php echo ($_GET['genero1'] ?? '') == 'Ação' ? 'selected' : ''; ?>>Ação</option>
                    <option value="Medieval" <?php echo ($_GET['genero1'] ?? '') == 'Medieval' ? 'selected' : ''; ?>>Medieval</option>
                </select>
            </div>

            <div class="form-group" id="div_didatico" style="display: none;">
                <label>Gênero (Didático):</label>
                <select name="genero2" style="width:100%; padding:8px;">
                    <option value="">Todos</option>
                    <option value="Matemática" <?php echo ($_GET['genero2'] ?? '') == 'Matemática' ? 'selected' : ''; ?>>Matemática</option>
                    <option value="Física" <?php echo ($_GET['genero2'] ?? '') == 'Física' ? 'selected' : ''; ?>>Física</option>
                    <option value="Ciências" <?php echo ($_GET['genero2'] ?? '') == 'Ciências' ? 'selected' : ''; ?>>Ciências</option>
                    <option value="Geografia" <?php echo ($_GET['genero2'] ?? '') == 'Geografia' ? 'selected' : ''; ?>>Geografia</option>
                </select>
            </div>

            <div class="form-group" id="div_revista" style="display: none;">
                <label>Gênero (Revista):</label>
                <select name="genero3" style="width:100%; padding:8px;">
                    <option value="">Todos</option>
                    <option value="Lazer" <?php echo ($_GET['genero3'] ?? '') == 'Lazer' ? 'selected' : ''; ?>>Lazer</option>
                    <option value="Esportes" <?php echo ($_GET['genero3'] ?? '') == 'Esportes' ? 'selected' : ''; ?>>Esportes</option>
                    <option value="Moda" <?php echo ($_GET['genero3'] ?? '') == 'Moda' ? 'selected' : ''; ?>>Moda</option>
                    <option value="Geral" <?php echo ($_GET['genero3'] ?? '') == 'Geral' ? 'selected' : ''; ?>>Geral</option>
                </select>
            </div>

            <div class="form-group">
                <label>Condição:</label>
                <select name="condicao" style="width:100%; padding:8px;">
                    <option value="">Todas</option>
                    <option value="Novo" <?php echo ($_GET['condicao'] ?? '') == 'Novo' ? 'selected' : ''; ?>>Novo</option>
                    <option value="Seminovo" <?php echo ($_GET['condicao'] ?? '') == 'Seminovo' ? 'selected' : ''; ?>>Seminovo</option>
                    <option value="Bom estado" <?php echo ($_GET['condicao'] ?? '') == 'Bom estado' ? 'selected' : ''; ?>>Bom estado</option>
                </select>
            </div>

            <div class="form-group">
                <label>Estado (UF):</label>
                <select name="estado" style="width:100%; padding:8px;">
                    <option value="">Todos</option>
                    <option value="PR" <?php echo ($_GET['estado'] ?? '') == 'PR' ? 'selected' : ''; ?>>Paraná</option>
                    <option value="SC" <?php echo ($_GET['estado'] ?? '') == 'SC' ? 'selected' : ''; ?>>Santa Catarina</option>
                    <option value="RS" <?php echo ($_GET['estado'] ?? '') == 'RS' ? 'selected' : ''; ?>>Rio Grande do Sul</option>
                    <option value="SP" <?php echo ($_GET['estado'] ?? '') == 'SP' ? 'selected' : ''; ?>>São Paulo</option>
                </select>
            </div>
            <button type="submit" class="btn-search">Filtrar</button>
            <a href="pesquisa_view.php" style="text-decoration:none; color:#666; font-size:12px; align-self:center;">Limpar Filtros</a>
        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th>Título</th>
                <th>Categoria</th>
                <th>Gênero</th>
                <th>Preço</th>
                <th>Condição</th>
                <th>Localização (UF)</th>
                <th>Data</th>
                <th>Ação</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($livros) > 0): ?> <!-- Se a conta de livros for maior que zero... !-->
                <?php foreach ($livros as $livro): ?> <!--...para cada livro encontrado...-->
                    <tr>
                        <td><?php echo htmlspecialchars($livro['titulo']); ?></td>
                        <td><?php echo htmlspecialchars($livro['categoria']); ?></td>
                        <td><?php echo htmlspecialchars($livro['genero']); ?></td>
                        <td>R$ <?php echo number_format($livro['preco'], 2, ',', '.'); ?></td>
                        <td><?php echo htmlspecialchars($livro['condicao']); ?></td>
                        <td><strong><?php echo htmlspecialchars($livro['estado']); ?></strong></td>
                        <td><?php echo date('d/m/Y', strtotime($livro['cadastrado_em'])); ?></td>
                        <td>
                            <button onclick="cookieChat('<?php echo $livro['id_usuario']; ?>', '<?php echo $livro['id_livro']; ?>', '<?php echo htmlspecialchars($livro['titulo'], ENT_QUOTES); ?>')">Eu quero!</button>
                        </td>
                        <script src="pesquisa.js"></script>
                    </tr>
                <?php endforeach; ?> <!--...exibe os detalhes do livro em uma linha da tabela.!-->
            <?php else: ?>
                <tr>
                    <td colspan="6" class="no-results">Nenhum livro encontrado com esses filtros.</td>
                </tr> <!-- Se não houver livros encontrados, exibe uma mensagem informando que nenhum livro corresponde aos filtros aplicados. -->
            <?php endif; ?>
        </tbody>
    </table>
    <a href="homepage_view.php">Voltar para página principal</a>
<?php include 'footer.php'; ?>
</body>
</html>