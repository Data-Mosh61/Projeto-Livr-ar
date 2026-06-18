<?php
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_id'] === NULL) {
    header("Location: login_view.php");
    exit;
}

$usuario_id_logado = $_SESSION['usuario_id'];
$mensagem = '';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $acao = $_POST['acao'] ?? '';
    $id_livro_acao = $_POST['id_livro'] ?? 0;

    if ($id_livro_acao > 0) { // 1. Verifica se o ID do livro é válido
        try {
            if ($acao === 'excluir') {
                // 2. Exclui o livro do banco
                $stmt = $pdo->prepare("DELETE FROM livros
                                       WHERE id_livro = :id_livro AND id_usuario = :id_usuario");
                $stmt->execute([':id_livro' => $id_livro_acao, ':id_usuario' => $usuario_id_logado]);
                $mensagem = "Livro excluído com sucesso!";
                
            } elseif ($acao === 'tornar_disponivel') {
                // 3. Marca o livro como disponível novamente -> Disponibilidade 0
                $stmt = $pdo->prepare("UPDATE livros SET disponibilidade = 0 WHERE id_livro = :id_livro AND id_usuario = :id_usuario");
                $stmt->execute([':id_livro' => $id_livro_acao, ':id_usuario' => $usuario_id_logado]);
                $mensagem = "Livro marcado como disponível novamente!";
                
            } elseif ($acao === 'arquivar') {
                // 4. Arquiva o livro -> Disponibilidade 2
                $stmt = $pdo->prepare("UPDATE livros SET disponibilidade = 2 WHERE id_livro = :id_livro AND id_usuario = :id_usuario");
                $stmt->execute([':id_livro' => $id_livro_acao, ':id_usuario' => $usuario_id_logado]);
                $mensagem = "Livro arquivado com sucesso!";
            }
        } catch (PDOException $e) {
            $mensagem = "Erro ao processar a ação: " . $e->getMessage();
        }
    }
}

// 5. Busca todos os livros do usuário logado para exibir na página de gerenciamento
$query = "SELECT l.*, u.estado, g.categoria, g.genero AS genero
          FROM livros l
          LEFT JOIN usuarios u ON l.id_usuario = u.id 
          LEFT JOIN generos g ON l.id_genero = g.id_genero
          WHERE l.id_usuario = :id_usuario
          ORDER BY l.cadastrado_em DESC";
$stmt = $pdo->prepare($query);
$stmt->execute([':id_usuario' => $usuario_id_logado]);
$todos_meus_livros = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 6. Separando os livros por status de disponibilidade
$livros_disponiveis = []; // 7. Disponibilidade = 0
$livros_pendentes   = []; // 8. Disponibilidade = 1
$livros_arquivados  = []; // 9. Disponibilidade = 2

foreach ($todos_meus_livros as $livro) {
    if ($livro['disponibilidade'] == 0) {
        $livros_disponiveis[] = $livro;
    } elseif ($livro['disponibilidade'] == 1) {
        $livros_pendentes[] = $livro;
    } elseif ($livro['disponibilidade'] == 2) {
        $livros_arquivados[] = $livro;
    }
}
?>