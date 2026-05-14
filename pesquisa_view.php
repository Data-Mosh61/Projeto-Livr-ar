<?php
    include 'pesquisa.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Catálogo de Livros</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <h2>Catálogo de Livros Disponíveis</h2>

    <div class="filter-section">
        <form method="GET" class="filter-form">
            <div>
                <label>Título:</label>
                <input type="text" name="titulo" value="<?php echo $_GET['titulo'] ?? ''; ?>" style="width:100%; padding:8px;">
            </div>

            <div>
                <label>Gênero:</label>
                <select name="genero" style="width:100%; padding:8px;">
                    <option value="">Todos</option>
                    <option value="Mistério" <?php echo ($_GET['genero'] ?? '') == 'Mistério' ? 'selected' : ''; ?>>Mistério</option>
                    <option value="Ficção Cientifica" <?php echo ($_GET['genero'] ?? '') == 'Ficção Cientifica' ? 'selected' : ''; ?>>Ficção Científica</option>
                    <option value="Ação" <?php echo ($_GET['genero'] ?? '') == 'Ação' ? 'selected' : ''; ?>>Ação</option>
                    <option value="Medieval" <?php echo ($_GET['genero'] ?? '') == 'Medieval' ? 'selected' : ''; ?>>Medieval</option>
                </select>
            </div>

            <div>
                <label>Condição:</label>
                <select name="condicao" style="width:100%; padding:8px;">
                    <option value="">Todas</option>
                    <option value="Novo" <?php echo ($_GET['condicao'] ?? '') == 'Novo' ? 'selected' : ''; ?>>Novo</option>
                    <option value="Seminovo" <?php echo ($_GET['condicao'] ?? '') == 'Seminovo' ? 'selected' : ''; ?>>Seminovo</option>
                    <option value="Bom estado" <?php echo ($_GET['condicao'] ?? '') == 'Bom estado' ? 'selected' : ''; ?>>Bom estado</option>
                </select>
            </div>

            <div>
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
                <th>Gênero</th>
                <th>Preço</th>
                <th>Condição</th>
                <th>Localização (UF)</th>
                <th>Data</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($livros) > 0): ?>
                <?php foreach ($livros as $livro): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($livro['titulo']); ?></td>
                        <td><?php echo htmlspecialchars($livro['genero']); ?></td>
                        <td>R$ <?php echo number_format($livro['preco'], 2, ',', '.'); ?></td>
                        <td><?php echo htmlspecialchars($livro['condicao']); ?></td>
                        <td><strong><?php echo htmlspecialchars($livro['estado']); ?></strong></td>
                        <td><?php echo date('d/m/Y', strtotime($livro['cadastrado_em'])); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="no-results">Nenhum livro encontrado com esses filtros.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <a href="homepage.html">Voltar para página principal</a>

</body>
</html>