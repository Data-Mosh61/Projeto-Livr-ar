<?php
// 1. Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_id'] === NULL) {
    header("Location: login_view.php");
    exit;
}

$usuario_id_logado = $_SESSION['usuario_id'];
$mensagem = '';
$erro = '';

// 2. Captura o ID do livro da URL (GET) ou do formulário (POST)
$id_livro = $_GET['id'] ?? $_POST['id_livro'] ?? 0;

if (!$id_livro) {
    die("ID do livro não fornecido.");
}

// 3. PROCESSAMENTO DO FORMULÁRIO (UPDATE)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = trim($_POST['titulo']);
    $preco = trim($_POST['preco']);
    $condicao = $_POST['condicao'];
    $categoria = $_POST['categoria'] ?? '';
    
    // Define qual gênero foi selecionado com base na categoria
    $genero = '';
    if ($categoria === 'Gibi' || $categoria === 'Livro') {
        $genero = $_POST['genero1'] ?? '';
    } elseif ($categoria === 'Didático') {
        $genero = $_POST['genero2'] ?? '';
    } elseif ($categoria === 'Revista') {
        $genero = $_POST['genero3'] ?? '';
    }

    $preco_formatado = str_replace(',', '.', $preco);

    if (empty($titulo) || empty($preco) || empty($condicao) || empty($categoria) || empty($genero)) {
        $erro = "Por favor, preencha todos os campos do livro e selecione a categoria/gênero corretamente.";
    } else {
        try {
            // A. Busca se esse gênero já existe na tabela 'generos'
            $stmt_gen = $pdo->prepare("SELECT id_genero FROM generos WHERE categoria = :categoria AND genero = :genero LIMIT 1");
            $stmt_gen->execute([':categoria' => $categoria, ':genero' => $genero]);
            $row_genero = $stmt_gen->fetch(PDO::FETCH_ASSOC);

            // B. Se o gênero não existe, insere automaticamente para não quebrar o banco de dados
            if ($row_genero) {
                $id_genero_final = $row_genero['id_genero'];
            } else {
                $stmt_ins = $pdo->prepare("INSERT INTO generos (categoria, genero) VALUES (:categoria, :genero)");
                $stmt_ins->execute([':categoria' => $categoria, ':genero' => $genero]);
                $id_genero_final = $pdo->lastInsertId();
            }

            // C. Atualiza o livro usando o id_genero correto
            $stmt = $pdo->prepare("UPDATE livros SET titulo = :titulo, preco = :preco, condicao = :condicao, id_genero = :id_genero WHERE id_livro = :id_livro AND id_usuario = :id_usuario");
            
            $sucesso = $stmt->execute([
                ':titulo' => $titulo,
                ':preco' => $preco_formatado,
                ':condicao' => $condicao,
                ':id_genero' => $id_genero_final,
                ':id_livro' => $id_livro,
                ':id_usuario' => $usuario_id_logado
            ]);

            if ($sucesso) {
                $mensagem = "Livro atualizado com sucesso!";
            } else {
                $erro = "Não foi possível atualizar o livro.";
            }
        } catch (PDOException $e) {
            $erro = "Erro ao atualizar: " . $e->getMessage();
        }
    }
}

// 4. BUSCA OS DADOS ATUAIS DO LIVRO (Incluindo os nomes da categoria e gênero atuais)
try {
    $query = "SELECT l.*, g.categoria, g.genero 
              FROM livros l 
              JOIN generos g ON l.id_genero = g.id_genero 
              WHERE l.id_livro = :id_livro AND l.id_usuario = :id_usuario";
    $stmt = $pdo->prepare($query);
    $stmt->execute([
        ':id_livro' => $id_livro,
        ':id_usuario' => $usuario_id_logado
    ]);
    $livro = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$livro) {
        die("Livro não encontrado ou você não tem permissão para editá-lo.");
    }
} catch (PDOException $e) {
    die("Erro ao buscar dados do livro: " . $e->getMessage());
}
?>