<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-warning border-bottom border-secondary">
        <div class="container-fluid">
            <a class="navbar-brand" href="homepage_view.php">
                <img src="logo.png" alt="Logo" width="40" height="40" class="d-inline-block align-text-top">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="pesquisa_view.php">Pesquisar Livros</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="livro_cadastro_view.php">Cadastrar Livro</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Área do Usuário
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <?php if (isset($_SESSION['usuario_id']) && $_SESSION['usuario_id'] !== NULL): ?>
                                <li><a class="dropdown-item" href="meus_livros_view.php">Meus Livros</a></li>
                                <li><a class="dropdown-item" href="chat_view.php">Chat</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                            <?php else: ?>
                                <li><a class="dropdown-item" href="cadastro_view.php">Criar Conta</a></li>
                                <li><a class="dropdown-item" href="login_view.php">Entrar</a></li>
                            <?php endif; ?>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>