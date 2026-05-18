function toggleCnpj() {
    var isJuridica = document.getElementById('tipo_juridica').checked;
    var divCnpj = document.getElementById('div_cnpj');
    var inputCnpj = document.getElementById('cnpj');

    if (isJuridica) {
    divCnpj.style.display = 'block';
        inputCnpj.required = true; // 1. Força o preenchimento no HTML
    } else {
        divCnpj.style.display = 'none';
        inputCnpj.required = false;
        inputCnpj.value = ''; // 2. Limpa o campo se a pessoa mudar de ideia
    }
}