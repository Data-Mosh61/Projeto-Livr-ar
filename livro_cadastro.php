<?php

// 1. Verifica login
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_id'] === NULL) {
    header("Location: login_view.php");
    exit;
}

// 2. Processamento do formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_usuario = $_SESSION['usuario_id'];
    $titulo = trim($_POST['titulo']);
    $preco = str_replace(',', '.', $_POST['preco']); 
    $categoria = $_POST['categoria'];
    $condicao = $_POST['condicao'];
    
    // 3. Descobre qual gênero foi preenchido com base na categoria
    $genero_final = null;
    if ($categoria === 'Gibi' || $categoria === 'Livro') {
        $genero_final = !empty($_POST['genero1']) ? $_POST['genero1'] : null;
    } elseif ($categoria === 'Didático') {
        $genero_final = !empty($_POST['genero2']) ? $_POST['genero2'] : null;
    } elseif ($categoria === 'Revista') {
        $genero_final = !empty($_POST['genero3']) ? $_POST['genero3'] : null;
    } // 4. Se o usuário não selecionou um gênero correspondente, $genero_final ficará null

    // 5. Validações básicas
    if (empty($titulo) || empty($categoria) || empty($condicao)) {
        $mensagem = "Preencha todos os campos obrigatórios (Título, Categoria e Condição).";
    } elseif (empty($genero_final)) {
        $mensagem = "Por favor, selecione um gênero correspondente à categoria escolhida."; // 6. Mensagem específica para gênero
    } else {
        
        try {
            $pdo->beginTransaction(); // 7. Inicia uma transação para garantir que tudo salve junto

            // 8. Verifica se o gênero já existe na tabela 'generos'
            $sql_busca_genero = "SELECT id_genero
                                FROM generos 
                                WHERE categoria = :categoria AND genero = :genero";
            $stmt_busca = $pdo->prepare($sql_busca_genero);
            $stmt_busca->bindParam(':categoria', $categoria);
            $stmt_busca->bindParam(':genero', $genero_final);
            $stmt_busca->execute();
            
            $id_genero = null;

            if ($stmt_busca->rowCount() > 0) {
                // 9. Se o gênero já existe, seleciona o ID para usar como foreign key
                $row = $stmt_busca->fetch(PDO::FETCH_ASSOC);
                $id_genero = $row['id_genero'];
            } else {
                // 10. Se não existe, cria um novo e pega o ID recém-criado
                $sql_insere_genero = "INSERT INTO generos (categoria, genero)
                                      VALUES (:categoria, :genero)";
                $stmt_insere = $pdo->prepare($sql_insere_genero);
                $stmt_insere->bindParam(':categoria', $categoria);
                $stmt_insere->bindParam(':genero', $genero_final);
                $stmt_insere->execute();
                
                $id_genero = $pdo->lastInsertId();
            }

            // 11. Agora salva o livro referenciando a foreign key ($id_genero)
            $sql_livro = "INSERT INTO livros (id_usuario, titulo, preco, condicao, id_genero) 
                          VALUES (:id_usuario, :titulo, :preco, :condicao, :id_genero)";
            
            $stmt_livro = $pdo->prepare($sql_livro);
            $stmt_livro->bindParam(':id_usuario', $id_usuario);
            $stmt_livro->bindParam(':titulo', $titulo);
            $stmt_livro->bindParam(':preco', $preco);
            $stmt_livro->bindParam(':condicao', $condicao);
            $stmt_livro->bindParam(':id_genero', $id_genero); // 12. Adicionando a Foreign Key
            
            $stmt_livro->execute();

            $pdo->commit(); // 13. Confirma a transação
            $mensagem = "Livro cadastrado com sucesso!";

        } catch(PDOException $e) {
            $pdo->rollBack(); // 14. Desfaz tudo se der erro no meio do caminho
            $mensagem = "Erro ao cadastrar: " . $e->getMessage();
        }
    }
}
?>