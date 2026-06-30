let usuarioChatAtual = null; // 1. Inicializando a variável corretamente

function carregarChats() {
    let formData = new FormData();
    formData.append('acao', 'pega_chats'); // 2. Certifique-se de que 'pega_chats' é a ação correta para obter os chats do usuário
            
    fetch('chat.php', { method: 'POST', body: formData })
        .then(res => res.json())
        .then(data => {
            let html = '';
            if (data && data.length > 0) {
                data.forEach(usuario => {
                    html += `<div class="usuario-item" onclick="abrirChat(${usuario.id}, '${usuario.nome}')">${usuario.nome}</div>`;
                }); // 3. Para cada usuário encontrado, crie um item na lista de chats para que o usuário possa clicar e abrir o chat correspondente
            }
            document.getElementById('lista-chat').innerHTML = html;
        }).catch(err => console.error("Erro ao carregar chats: ", err)); // 4. Adicionando tratamento de erro para a requisição fetch
}

function abrirChat(id_usuario, nome_usuario) {
    usuarioChatAtual = id_usuario;
    document.getElementById('titulo-chat').innerText = "Conversando com: " + nome_usuario;
    carregarMensagens();  // 5. Carregando as mensagens do chat assim que o chat é aberto
}

function carregarMensagens() {
    if (!usuarioChatAtual) return; // 6. Verificando se 'usuarioChatAtual' está definido antes de tentar carregar as mensagens

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
                }); // 7. Para cada mensagem, determine se ela foi enviada ou recebida e aplique a classe CSS correspondente
            }
            document.getElementById('mensagens').innerHTML = html;
        }).catch(err => console.error("Erro ao carregar mensagens: ", err));
}

function enviarMensagem() {
    if (!usuarioChatAtual) return alert("Selecione um usuário para conversar primeiro!"); // 8. Check simples para garantir que um chat esteja aberto
            
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
        }).catch(err => console.error("Erro ao enviar mensagem: ", err)); // 9. Adicionando tratamento de erro para a requisição fetch ao enviar uma mensagem
}

function buscarUsuario() { 
    let id = document.getElementById('buscar-id').value;
    let formData = new FormData();
    formData.append('acao', 'buscar_usuario');
    formData.append('buscar_id', id); // 10. Buscando um usuário específico para iniciar um chat

    fetch('chat.php', { method: 'POST', body: formData })
        .then(res => res.json())
        .then(user => {
            if (user && user.id) {
                abrirChat(user.id, user.nome); // 11. Se o usuário for encontrado, abra o chat com ele
            } else {
                alert("Usuário não encontrado!");
            }
        }).catch(err => console.error("Erro ao buscar usuário: ", err));
}

// 12. Função auxiliar para ler um cookie específico
function getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(';').shift();
    return null;
}

// 13. Função auxiliar para deletar o cookie
function deletarCookie(name) {
    document.cookie = name + '=; Max-Age=0; path=/';
}

// 14. Função que verifica se viemos da página de pesquisa
function verificarChatPendente() {
    let idProprietario = getCookie('id_proprietario');
    let tituloLivro = getCookie('titulo_livro');

    if (idProprietario && tituloLivro) {
        // 15. Decodifica o título que codificamos no pesquisa.js
        let tituloFormatado = decodeURIComponent(tituloLivro);
        
        // 16. Destrói os cookies imediatamente para não mandar mensagem dupla se atualizar a página
        deletarCookie('id_proprietario');
        deletarCookie('titulo_livro');

        // 17. Busca os dados do proprietário para abrir o chat corretamente
        let formData = new FormData();
        formData.append('acao', 'buscar_usuario');
        formData.append('buscar_id', idProprietario);

        fetch('chat.php', { method: 'POST', body: formData })
            .then(res => res.json())
            .then(user => {
                if (user && user.id) {
                    // 18. Abre a janela de chat com esse usuário
                    abrirChat(user.id, user.nome);
                    
                    // 19. Monta e envia a mensagem automatizada
                    let msgAutomatica = `Olá! Estou interessado no livro "${tituloFormatado}"!`;
                    
                    let formDataMsg = new FormData();
                    formDataMsg.append('acao', 'envia_mensagem');
                    formDataMsg.append('recebedor', user.id);
                    formDataMsg.append('mensagem', msgAutomatica);

                    fetch('chat.php', { method: 'POST', body: formDataMsg })
                        .then(() => {
                            // 20. Atualiza a tela após enviar
                            carregarMensagens(); 
                            carregarChats(); 
                        }).catch(err => console.error("Erro ao enviar msg automática: ", err));
                }
            });
    }
}

// Inicializações ao carregar a página
carregarChats();
verificarChatPendente(); // Verifica se há uma interação pendente vinda da pesquisa

// 12. Carregar os chats do usuário assim que a página for carregadae
carregarChats();

// 13. A cada dois segundos, recarrega as mensagens e os chats sem que o usuário precise atualizar a página
setInterval(() => {
    carregarMensagens();
    carregarChats();
}, 2000);
