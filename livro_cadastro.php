<?php
session_start();

// 1. Verifica se o usuário está logado para obter o id_usuario e associar o livro a ele
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_id'] === NULL) {
    header ("Location: login_view.php"); // Se o usuario não estiver logado, redireciona para a página de login
}

// 2. Configurações de conexão com o banco de dados
$host = 'localhost';
$nome_bd = 'livr_ar';
$usuario_bd = 'root';
$senha_bd = '';

$mensagem = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$nome_bd;charset=utf8", $usuario_bd, $senha_bd);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    error_log("Erro de conexão com o banco de dados: " . $e->getMessage());
    die("Erro ao conectar ao banco de dados. Tente novamente mais tarde.");
}

// 3. Verificando se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_usuario = $_SESSION['usuario_id'];
    $titulo = trim($_POST['titulo']);

    // 4. Converte vírgula em ponto para o banco de dados aceitar o formato decimal
    $preco = str_replace(',', '.', $_POST['preco']); 
    $genero = $_POST['genero'];
    $condicao = $_POST['condicao'];

    if (!empty($titulo) && !empty($genero) && !empty($condicao)) { 
        
        //5. Se os campos obrigatórios estiverem preenchidos, tenta inserir o livro no banco de dados
        try {
            $sql = "INSERT INTO livros (id_usuario, titulo, preco, genero, condicao) 
                    VALUES (:id_usuario, :titulo, :preco, :genero, :condicao)";
            
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id_usuario', $id_usuario);
            $stmt->bindParam(':titulo', $titulo);
            $stmt->bindParam(':preco', $preco);
            $stmt->bindParam(':genero', $genero);
            $stmt->bindParam(':condicao', $condicao);
            
            if ($stmt->execute()) {
                $mensagem = "Livro cadastrado com sucesso!";
            }
        } catch(PDOException $e) {
            $mensagem = "Erro ao cadastrar: " . $e->getMessage();
        }
    } else {
        $mensagem = "Preencha todos os campos obrigatórios.";
    }
}
?>