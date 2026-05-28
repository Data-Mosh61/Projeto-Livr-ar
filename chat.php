<?php
    include 'conexao_bd.php';

 // 1. Verificando se o usuário está logado antes de permitir acesso ao chat
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_id'] === NULL) {
    header("Location: login_view.php");
    exit;
}
// 2. Garantindo que o ID do usuário logado esteja disponível para as operações de chat para evitar erroso

$meu_id = $_SESSION['usuario_id']; 
$acao = $_POST['acao'] ?? '';

// 3. Selecione todos os chats destinados ao usuário logado
if ($acao == 'pega_chats') { 
    $stmt = $pdo->prepare("SELECT DISTINCT u.id, u.nome 
                           FROM usuarios u
                           JOIN mensagens m ON (u.id = m.remetente OR u.id = m.recebedor)
                           WHERE (m.remetente = ? OR m.recebedor = ?) AND u.id != ?
                           ORDER BY u.nome ASC");
    $stmt->execute([$meu_id, $meu_id, $meu_id]);
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));

    // 4. Buscando as mensagens entre o usuário logado e outro usuário selecnionado
} elseif ($acao == 'pega_mensagens') {
    $outro_id = $_POST['outro_id'];
    $stmt = $pdo->prepare("SELECT * FROM mensagens 
                           WHERE (remetente = ? AND recebedor = ?)
                           OR (remetente = ? AND recebedor = ?)
                           ORDER BY envio ASC");
    $stmt->execute([$meu_id, $outro_id, $outro_id, $meu_id]);
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

// 5. Enviando uma nova mensagem
elseif ($acao == 'envia_mensagem') { 
    $recebedor = $_POST['recebedor'];
    $mensagem = trim($_POST['mensagem']);
    
    if (!empty($mensagem) && !empty($recebedor)) { // 7. Validando se a mensagem e o recebedor não estão vazios
        $stmt = $pdo->prepare("INSERT INTO mensagens (remetente, recebedor, mensagem)
                               VALUES (?, ?, ?)");
        $stmt->execute([$meu_id, $recebedor, $mensagem]);
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Mensagem ou recebedor vazios']);
    }

    // 8. Buscando informações de um usuário específico para exibir no chat
} elseif ($acao == 'buscar_usuario') {
    $buscar_id = $_POST['buscar_id'];
    $stmt = $pdo->prepare("SELECT id, nome
                           FROM usuarios
                           WHERE id = ?");
    $stmt->execute([$buscar_id]);
    echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
}
?>
