const meu_id = "<?php echo json_encode($_SESSION['usuario_id']); ?>"; // 1. Certifique-se de que 'usuario_id' está definido na sessão
let usuarioChatAtual = null; // 2. Inicializando a variável corretamente

function carregarChats() {
    let formData = new FormData();
    formData.append('acao', 'pega_chats'); // 3. Certifique-se de que 'pega_chats' é a ação correta para obter os chats do usuário
            
    fetch('chat.php', { method: 'POST', body: formData })
        .then(res => res.json())
        .then(data => {
            let html = '';
            if (data && data.length > 0) { // 4. Verificando se 'data' é um array e tem elementos antes de iterar
                data.forEach(usuario => {
                    html += `<div class="usuario-item" onclick="abrirChat(${usuario.id}, '${usuario.nome}')">${usuario.nome}</div>`;
                });
            }
            document.getElementById('lista-chat').innerHTML = html;
        }).catch(err => console.error("Erro ao carregar chats: ", err)); // 5. Adicionando tratamento de erro para a requisição fetch
}

function abrirChat(id_usuario, nome_usuario) { // 6. Certifique-se de que 'id_usuario' e 'nome_usuario' estão sendo passados corretamente para a função
    usuarioChatAtual = id_usuario;
    document.getElementById('titulo-chat').innerText = "Conversando com: " + nome_usuario;
    carregarMensagens();  // 7. Carregando as mensagens do chat assim que o chat é aberto para garantir que as mensagens sejam exibidas corretamente
}

function carregarMensagens() {
    if (!usuarioChatAtual) return; // 8. Verificando se 'usuarioChatAtual' está definido antes de tentar carregar as mensagens para evitar erros

    let formData = new FormData();
    formData.append('acao', 'pega_mensagens');
    formData.append('outro_id', usuarioChatAtual);

    fetch('chat.php', { method: 'POST', body: formData })
        .then(res => res.json())
        .then(data => {
            let html = '';
            if (data && data.length > 0) {
                data.forEach(msg => {
                    let tipo = (msg.remetente == meu_id) ? 'enviada' : 'recebida';
                    html += `<div style="display:flex;"><div class="${tipo}">${msg.mensagem}</div></div>`;
                }); // 9. Certifique-se de que 'msg.remetente' e 'msg.mensagem' estão sendo retornados corretamente do backend para evitar erros ao construir o HTML das mensagens
            }
            document.getElementById('mensagens').innerHTML = html;
        }).catch(err => console.error("Erro ao carregar mensagens: ", err));
}

function enviarMensagem() {
    if (!usuarioChatAtual) return alert("Selecione um usuário para conversar primeiro!"); // 10. Verificando se um chat está aberto antes de tentar enviar uma mensagem para evitar erros e melhorar a experiência do usuário
            
    let input = document.getElementById('msg-input');
    if (input.value.trim() === '') return;

    let formData = new FormData();
    formData.append('acao', 'envia_mensagem');
    formData.append('recebedor', usuarioChatAtual);
    formData.append('mensagem', input.value);

    fetch('chat.php', { method: 'POST', body: formData }) // 11. Certifique-se de que 'envia_mensagem' é a ação correta para enviar mensagens no backend e que os parâmetros 'recebedor' e 'mensagem' estão sendo processados corretamente para evitar erros ao enviar mensagens
        .then(res => res.json())
        .then(() => {
            input.value = '';
            carregarMensagens(); 
            carregarChats(); 
        }).catch(err => console.error("Erro ao enviar mensagem: ", err));
}

function buscarUsuario() { // 12. Certifique-se de que o campo de busca de usuário está presente no HTML e que o ID 'buscar-id' está correto para evitar erros ao tentar buscar um usuário
    let id = document.getElementById('buscar-id').value;
    let formData = new FormData();
    formData.append('acao', 'buscar_usuario');
    formData.append('buscar_id', id);

    fetch('chat.php', { method: 'POST', body: formData })
        .then(res => res.json())
        .then(user => {
            if (user && user.id) {
                abrirChat(user.id, user.nome);
            } else {
                alert("Usuário não encontrado!");
            }
        }).catch(err => console.error("Erro ao buscar usuário: ", err));
}

// 13. Carregar os chats do usuário assim que a página for carregada para garantir que a lista de chats esteja disponível para o usuário imediatamente
carregarChats();

// 14. Atualizações ao vivo, a cada 2 segundos
setInterval(() => {
    carregarMensagens();
    carregarChats();
}, 2000);
