<?php
    include 'conexao_bd.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <title>Homepage</title>
</head>
<body>
    <?php include 'header.php'; ?>
    <?php if (isset($_SESSION['usuario_id']) && $_SESSION['usuario_id'] !== NULL) {
        include 'pendencias.php';
    }
    ?>
    <h1>Bem-vindo à Livr-ar!</h1>
    <p>Explore nosso catálogo de livros usados e encontre ótimas ofertas.</p>
    <p>Temos
        <?php
            $stmt = $pdo->query("SELECT COUNT(*) FROM livros
                                 WHERE disponibilidade = 0");
            $total_livros_disponiveis = $stmt->fetchColumn();
            echo $total_livros_disponiveis;
        ?>
        livros disponíveis!
    </p>
    <?php include 'footer.php'; ?>
</body>
</html>
