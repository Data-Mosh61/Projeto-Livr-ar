<?php
include 'conexao_bd.php';

// Certifique-se de que session_start() está sendo chamado em conexao_bd.php!

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_livro'])) {
    $id_livro = $_POST['id_livro']; // 1. Recebe o ID do livro via POST
    
    // 2. Prepara a consulta para atualizar a disponibilidade do livro (1 = Indisponível)
    // Removida a checagem de id_usuario, pois quem clica não é o dono do livro.
    $stmt = $pdo->prepare("UPDATE livros 
                           SET disponibilidade = 1
                           WHERE id_livro = ?"); 
    
    // Executa passando apenas o id_livro
    if ($stmt->execute([$id_livro])) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error']); // 3. Retorna erro
    }
}
?>