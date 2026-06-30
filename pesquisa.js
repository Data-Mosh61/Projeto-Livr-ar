function toggleCategoria() {
    var isGibi = document.getElementById('gibi').selected;
    var isLivro = document.getElementById('livro').selected;
    var isDidatico = document.getElementById('didatico').selected;
    var isRevista = document.getElementById('revista').selected;

    if (isGibi || isLivro) {
        document.getElementById('div_gibi_livro').style.display = 'block';
    } else {
        document.getElementById('div_gibi_livro').style.display = 'none';
        document.getElementsByName('genero1')[0].value = ''; // Limpa seleção
    }

    if (isDidatico) {
        document.getElementById('div_didatico').style.display = 'block';
    } else {
        document.getElementById('div_didatico').style.display = 'none';
        document.getElementsByName('genero2')[0].value = ''; // Limpa seleção
    }

    if (isRevista) {
        document.getElementById('div_revista').style.display = 'block';
    } else {
        document.getElementById('div_revista').style.display = 'none';
        document.getElementsByName('genero3')[0].value = ''; // Limpa seleção
    }
}

toggleCategoria(); // Chama a função ao carregar a página para ajustar os campos conforme a categoria selecionada (ou não)

function cookieChat(idProprietario, idLivro, tituloLivro) {
    if (confirm("Deseja entrar em contato com o proprietário do livro?")) {
        
        let formData = new FormData();
        formData.append('id_livro', idLivro); // Passa o ID do livro para identificar qual livro está sendo solicitado

        // Atualiza a disponibilidade do livro no banco de dados
        fetch('disponibilidade.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                // Armazena os dados necessários em cookies para que o chat_view.php possa ler e agir de acordo
                document.cookie = "id_proprietario=" + idProprietario + "; path=/";
                document.cookie = "titulo_livro=" + encodeURIComponent(tituloLivro) + "; path=/";
                
                // Redireciona para o chat_view.php
                window.location.href = "chat_view.php";
            } else {
                alert("Erro ao atualizar a disponibilidade do livro no sistema.");
            }
        })
        .catch(err => console.error("Erro na requisição: ", err));
    }
}