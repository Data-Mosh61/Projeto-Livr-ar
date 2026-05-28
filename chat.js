const meu_id = "<?php echo json_encode($_SESSION['usuario_id']); ?>"; // 1. Certifique-se de que 'usuario_id' está definido na sessão
let usuarioChatAtual = null; // 2. Inicializando a variável corretamente

function carregarChats() {
    let formData = new FormData();
    formData.append('acao', 'pega_chats'); // 3. Certifique-se de que 'pega_chats' é a ação correta para obter os chats do usuário
            
    fetch('chat.php', { method: 'POST', body: formData })
        .then(res => res.json())
        .then(data => {
            let html = '';
            if (data && data.length > 0) {
                data.forEach(usuario => {
                    html += `<div class="usuario-item" onclick="abrirChat(${usuario.id}, '${usuario.nome}')">${usuario.nome}</div>`;
                }); // 4. Para cada usuário encontrado, crie um item na lista de chats para que o usuário possa clicar e abrir o chat correspondente
            }
            document.getElementById('lista-chat').innerHTML = html;
        }).catch(err => console.error("Erro ao carregar chats: ", err)); // 5. Adicionando tratamento de erro para a requisição fetch
}

function abrirChat(id_usuario, nome_usuario) {
    usuarioChatAtual = id_usuario;
    document.getElementById('titulo-chat').innerText = "Conversando com: " + nome_usuario;
    carregarMensagens();  // 6. Carregando as mensagens do chat assim que o chat é aberto
}

function carregarMensagens() {
    if (!usuarioChatAtual) return; // 8. Verificando se 'usuarioChatAtual' está definido antes de tentar carregar as mensagens

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
                }); // 9. Para cada mensagem, determine se ela foi enviada ou recebida e aplique a classe CSS correspondente
            }
            document.getElementById('mensagens').innerHTML = html;
        }).catch(err => console.error("Erro ao carregar mensagens: ", err));
}

function enviarMensagem() {
    if (!usuarioChatAtual) return alert("Selecione um usuário para conversar primeiro!"); // 10. Check simples para garantir que um chat esteja aberto
            
    let input = document.getElementById('msg-input');
    if (input.value.trim() === '') return;

    let formData = new FormData();
    formData.append('acao', 'envia_mensagem');
    formData.append('recebedor', usuarioChatAtual);
    formData.append('mensagem', input.value);

    fetch('chat.php', { method: 'POST', body: formData }) 
        .then(res => res.json())
        .then(() => {
            input.value = '';
            carregarMensagens(); 
            carregarChats(); 
        }).catch(err => console.error("Erro ao enviar mensagem: ", err)); // 11. Adicionando tratamento de erro para a requisição fetch ao enviar uma mensagem
}

function buscarUsuario() { 
    let id = document.getElementById('buscar-id').value;
    let formData = new FormData();
    formData.append('acao', 'buscar_usuario');
    formData.append('buscar_id', id); // 12. Buscando um usuário específico para iniciar um chat

    fetch('chat.php', { method: 'POST', body: formData })
        .then(res => res.json())
        .then(user => {
            if (user && user.id) {
                abrirChat(user.id, user.nome); // 13. Se o usuário for encontrado, abra o chat com ele
            } else {
                alert("Usuário não encontrado!");
            }
        }).catch(err => console.error("Erro ao buscar usuário: ", err));
}

// 14. Carregar os chats do usuário assim que a página for carregadae
carregarChats();

// 15. A cada dois segundos, recarrega as mensagens e os chats sem que o usuário precise atualizar a página
setInterval(() => {
    carregarMensagens();
    carregarChats();
}, 2000);
