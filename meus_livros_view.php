<?php
include 'conexao_bd.php';
include 'meus_livros.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Meus Livros</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <style>
        /* Estilos adicionais para as tabelas específicas */
        body { padding: 0px; margin: 0px;}
        .table-pendencias {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 30px;
        }
        .table-pendencias th {
            background-color: #ffd966; /* Amarelo */
            color: #333;
            padding: 10px;
        }
        .table-pendencias td {
            background-color: #fffaf0;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        .table-arquivados {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 30px;
            opacity: 0.85; /* Dá um aspecto visual "inativo" */
        }
        .table-arquivados th {
            background-color: #8c8c8c; /* Cinza */
            color: #fff;
            padding: 10px;
        }
        .table-arquivados td {
            background-color: #f2f2f2;
            padding: 10px;
            border-bottom: 1px solid #ddd;
            color: #555;
        }

        /* Botões de Ação Inline */
        .btn-acao {
            padding: 5px 10px;
            margin: 2px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
        }
        .btn-excluir { background-color: #dc3545; color: white; }
        .btn-disponivel { background-color: #28a745; color: white; }
        .btn-arquivar { background-color: #6c757d; color: white; }
        .form-inline { display: inline-block; margin: 0; }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    <h2>Gerenciamento de Meus Livros</h2>
    
    <?php if (!empty($mensagem)): ?>
        <div class="mensagem-alerta" style="color: green; font-weight: bold; margin-bottom: 15px;">
            <?php echo htmlspecialchars($mensagem); ?>
        </div>
    <?php endif; ?>

    <h3 style="color: #bfa12a;">Pendências (Livros com interesse)</h3>
    <table class="table-pendencias">
        <thead>
            <tr>
                <th>Título</th>
                <th>Categoria</th>
                <th>Preço</th>
                <th>Condição</th>
                <th>Data de Cadastro</th>
                <th>Ações de Pendência</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($livros_pendentes) > 0): ?>
                <?php foreach ($livros_pendentes as $livro): ?>
                    <tr>
                        <td><strong><?php echo htmlspecialchars($livro['titulo']); ?></strong></td>
                        <td><?php echo htmlspecialchars($livro['categoria'] ?? 'N/A'); ?></td>
                        <td>R$ <?php echo number_format($livro['preco'], 2, ',', '.'); ?></td>
                        <td><?php echo htmlspecialchars($livro['condicao']); ?></td>
                        <td><?php echo date('d/m/Y', strtotime($livro['cadastrado_em'])); ?></td>
                        <td>
                            <form method="POST" class="form-inline" onsubmit="return confirm('Deseja marcar este livro como DISPONÍVEL novamente?');">
                                <input type="hidden" name="acao" value="tornar_disponivel">
                                <input type="hidden" name="id_livro" value="<?php echo $livro['id_livro']; ?>">
                                <button type="submit" class="btn-acao btn-disponivel">✓ Livro Válido</button>
                            </form>

                            <form method="POST" class="form-inline" onsubmit="return confirm('Confirmar que o livro NÃO está mais disponível e arquivá-lo?');">
                                <input type="hidden" name="acao" value="arquivar">
                                <input type="hidden" name="id_livro" value="<?php echo $livro['id_livro']; ?>">
                                <button type="submit" class="btn-acao btn-arquivar">✗ Indisponível</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="6" style="text-align:center;">Você não possui livros com pendências no momento.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <hr style="margin: 30px 0; border: 1px solid #eee;">

    <h3>Meus Livros Ativos</h3>
    <table>
        <thead>
            <tr>
                <th>Título</th>
                <th>Categoria</th>
                <th>Gênero</th>
                <th>Preço</th>
                <th>Condição</th>
                <th>Data</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($livros_disponiveis) > 0): ?>
                <?php foreach ($livros_disponiveis as $livro): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($livro['titulo']); ?></td>
                        <td><?php echo htmlspecialchars($livro['categoria'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($livro['genero'] ?? 'N/A'); ?></td>
                        <td>R$ <?php echo number_format($livro['preco'], 2, ',', '.'); ?></td>
                        <td><?php echo htmlspecialchars($livro['condicao']); ?></td>
                        <td><?php echo date('d/m/Y', strtotime($livro['cadastrado_em'])); ?></td>
                        <td>
                            <a href="editar_livro_view.php?id=<?php echo $livro['id_livro']; ?>" style="font-size: 12px; margin-right: 5px;">Editar</a>
                            
                            <form method="POST" class="form-inline" onsubmit="return confirm('Tem certeza que deseja excluir permanentemente este livro?');">
                                <input type="hidden" name="acao" value="excluir">
                                <input type="hidden" name="id_livro" value="<?php echo $livro['id_livro']; ?>">
                                <button type="submit" class="btn-acao btn-excluir">Excluir</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="7" style="text-align:center;">Nenhum livro ativo no momento.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <hr style="margin: 30px 0; border: 1px solid #eee;">

    <h3 style="color: #666;">Arquivados (Indisponíveis)</h3>
    <table class="table-arquivados">
        <thead>
            <tr>
                <th>Título</th>
                <th>Categoria</th>
                <th>Preço</th>
                <th>Condição</th>
                <th>Data de Cadastro</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($livros_arquivados) > 0): ?>
                <?php foreach ($livros_arquivados as $livro): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($livro['titulo']); ?></td>
                        <td><?php echo htmlspecialchars($livro['categoria'] ?? 'N/A'); ?></td>
                        <td>R$ <?php echo number_format($livro['preco'], 2, ',', '.'); ?></td>
                        <td><?php echo htmlspecialchars($livro['condicao']); ?></td>
                        <td><?php echo date('d/m/Y', strtotime($livro['cadastrado_em'])); ?></td>
                        <td><em>Somente Leitura</em></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="6" style="text-align:center;">Nenhum livro arquivado.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <br>
    <a href="homepage_view.php">Voltar para página principal</a>
<?php include 'footer.php'; ?>
</body>
</html>