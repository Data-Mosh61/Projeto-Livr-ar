<?php
$parametros = [];
$parametros[':usuario_id'] = $_SESSION['usuario_id'];

    $stmt = $pdo->prepare("SELECT * FROM livros
                           WHERE disponibilidade = 1 and id_usuario = :usuario_id"); // 1. Consulta para selecionar os livros que estão indisponíveis (disponibilidade = 1)
    $stmt->execute($parametros);
    $livros_indisponiveis = $stmt->fetchAll(PDO::FETCH_ASSOC); // 2. Armazena os resultados em um array associativo

    if (count($livros_indisponiveis) > 0) {
        echo "<div class='alert alert-danger'>"; // 3. Exibe um alerta para o usuário se houver livros indisponíveis
        echo "<h2 class='alert alert-warning'>Aviso de pendencias!!</h2>";
        echo "<p> Você tem " . count($livros_indisponiveis) . " livro(s) indisponível(is) para venda!</p>";
        echo "<p>Atualize a disponibilidade dos seus livros</p><a href='meus_livros_view.php'>aqui!</a>";
        echo "<ul>";
        echo "</div>";
    }
?>