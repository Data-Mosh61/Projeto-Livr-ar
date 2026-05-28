<?php
    include 'conexao_bd.php';
 // 1. Verificando se o usuário está logado antes de permitir acesso ao chat para garantir a segurança e evitar erros ao tentar acessar informações de usuário não autenticado
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_id'] === NULL) {
    header("Location: login_view.php");
    exit;
}
// 2. Garantindo que o ID do usuário logado esteja disponível para as operações de chat para evitar erros ao tentar acessar informações de usuário

$meu_id = $_SESSION['usuario_id']; 
$acao = $_POST['acao'] ?? '';

if ($acao == 'pega_chats') { // 3. Corrigindo a consulta SQL para buscar os chats corretamente, garantindo que os usuários sejam listados apenas uma vez e ordenados por nome para melhorar a experiência do usuário
    $stmt = $pdo->prepare("SELECT DISTINCT u.id, u.nome 
                           FROM usuarios u
                           JOIN mensagens m ON (u.id = m.remetente OR u.id = m.recebedor)
                           WHERE (m.remetente = ? OR m.recebedor = ?) AND u.id != ?
                           ORDER BY u.nome ASC");
    $stmt->execute([$meu_id, $meu_id, $meu_id]);
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
} elseif ($acao == 'pega_mensagens') { // 4. Corrigindo a consulta SQL para buscar as mensagens corretamente, garantindo que as mensagens sejam ordenadas por data de envio para exibir o histórico de chat corretamente
    $outro_id = $_POST['outro_id'];
    $stmt = $pdo->prepare("SELECT * FROM mensagens 
                           WHERE (remetente = ? AND recebedor = ?)
                           OR (remetente = ? AND recebedor = ?)
                           ORDER BY envio ASC");
    $stmt->execute([$meu_id, $outro_id, $outro_id, $meu_id]);
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

elseif ($acao == 'envia_mensagem') { // 5. Corrigindo a lógica de envio de mensagens para garantir que as mensagens sejam salvas corretamente no banco de dados e associadas aos usuários corretos para evitar erros ao tentar enviar mensagens
    $recebedor = $_POST['recebedor'];
    $mensagem = trim($_POST['mensagem']);
    
    if (!empty($mensagem) && !empty($recebedor)) {
        $stmt = $pdo->prepare("INSERT INTO mensagens (remetente, recebedor, mensagem)
                               VALUES (?, ?, ?)");
        $stmt->execute([$meu_id, $recebedor, $mensagem]);
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Mensagem ou recebedor vazios']);
    }
} elseif ($acao == 'buscar_usuario') { // 6. Corrigindo a lógica de busca de usuários para garantir que os usuários sejam buscados corretamente no banco de dados e que as informações retornadas sejam adequadas para exibir o nome do usuário no chat para melhorar a experiência do usuário
    $buscar_id = $_POST['buscar_id'];
    $stmt = $pdo->prepare("SELECT id, nome
                           FROM usuarios
                           WHERE id = ?");
    $stmt->execute([$buscar_id]);
    echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
}
?>