<?php
    include 'conexao_bd.php';
    include 'usuario_cadastro.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro do Usuário</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="container">
        <?php if (isset($mensagem)) echo $mensagem; ?>
        <h2>Criar Nova Conta</h2>

    <form method="POST" action="">
        <div class="form-group">
            <label for="nome">Nome Completo *</label>
            <input type="text" name="nome" id="nome" required value="<?php echo htmlspecialchars($nome ?? ''); ?>">
        </div>

        <div class="form-group">
            <label>Pessoa jurídica ou física?</label>
            <input type="radio" name="tipo" id="tipo_fisica" value="fisica" required onchange="toggleCnpj()"> Pessoa Física
            <input type="radio" name="tipo" id="tipo_juridica" value="juridica" required onchange="toggleCnpj()"> Pessoa Jurídica
            
            <!-- CNPJ nicia escondido (display: none) -->
            <div id="div_cnpj" style="display: none; margin-top: 10px;">
                <input type="text" name="cnpj" id="cnpj" placeholder="CNPJ (apenas para Pessoa Jurídica)">
            </div>
            <script src="usuario_cadastro.js"></script>
        </div>

        <div class="form-group">
            <label for="email">E-mail *</label>
            <input type="email" name="email" id="email" required value="<?php echo htmlspecialchars($email ?? ''); ?>">
        </div>

        <div class="form-group">
            <label for="senha">Senha *</label>
            <input type="password" name="senha" id="senha" required>
        </div>

        <div class="form-group">
            <label for="estado">Estado *</label>
            <select name="estado" required>
                <option value="">Selecione...</option>
                <option value="PR">Paraná</option>
                <option value="SC">Santa Catarina</option>
                <option value="RS">Rio Grande do Sul</option>
                <option value="SP">São Paulo</option>
            </select>
        </div>

        <div class="form-group">
            <label for="telefone">Telefone (Opcional)</label>
            <input type="tel" name="telefone" id="telefone" placeholder="Ex: (00) 00000-0000" value="<?php echo htmlspecialchars($telefone ?? ''); ?>">
        </div>

        <button type="submit">Cadastrar</button>
    </form>
<a href="login_view.php">Já está cadastrado? Clique aqui</a>
</div>
</body>
</html>
