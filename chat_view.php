<?php
    include 'conexao_bd.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Chat</title>
    <style>
        body { display: flex; font-family: Arial; height: 100vh; margin: 0; }
        #sidebar { width: 30%; border-right: 1px solid #ccc; padding: 10px; }
        #janela-chat { width: 70%; display: flex; flex-direction: column; padding: 10px; }
        #mensagens { flex-grow: 1; overflow-y: auto; border: 1px solid #eee; padding: 10px; margin-bottom: 10px; }
        .enviada { padding: 5px 10px; margin: 5px 0; border-radius: 5px; max-width: 70%; display: block; background: #dcf8c6; align-self: flex-end; }
        .recebida { padding: 5px 10px; margin: 5px 0; border-radius: 5px; max-width: 70%; display: block; background: #f1f0f0; align-self: flex-start; }
        .usuario-item { cursor: pointer; padding: 10px; border-bottom: 1px solid #eee; }
        .usuario-item:hover { background: #f9f9f9; }
    </style>
</head>
<body>

    <div id="sidebar">
        <h3>Encontre usuários por ID</h3>
        <input type="number" id="buscar-id" placeholder="ID usuário">
        <button onclick="buscarUsuario()">Começar chat</button>
        
        <h3>Seus chats</h3>
        <div id="lista-chat"></div>
        <a href="homepage_view.php">Voltar à página inicial</a>
    </div>
    
    <div id="janela-chat">
        <h3 id="titulo-chat">Selecione um chat</h3>
        <div id="mensagens"></div>
        <div style="display: flex;">
            <input type="text" id="msg-input" placeholder="Escreva uma mensagem..." style="flex-grow: 1;">
            <button onclick="enviarMensagem()">Enviar</button>
        </div>
    </div>

    <script src="chat.js"></script> 
</body>
</html>