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