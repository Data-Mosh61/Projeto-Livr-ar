<?php
session_start();

// 1. Verifica se o usuário está logado para obter o id_usuario e associar o livro a ele
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_id'] === NULL) {
    header ("Location: login_view.php"); // Se o usuario não estiver logado, redireciona para a página de login
}

// Configurações do Banco de Dados
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

// Inicializa a consulta base com JOIN
// Buscamos colunas do livro (l) e o estado do usuário (u)
$sql = "SELECT l.*, u.estado 
        FROM livros l 
        JOIN usuarios u ON l.id_usuario = u.id 
        WHERE 1=1";

$parametros = [];

// Aplicando Filtros se existirem na URL (via GET)
if (!empty($_GET['titulo'])) {
    $sql .= " AND l.titulo LIKE :titulo";
    $parametros[':titulo'] = '%' . $_GET['titulo'] . '%';
}

if (!empty($_GET['genero'])) {
    $sql .= " AND l.genero = :genero";
    $parametros[':genero'] = $_GET['genero'];
}

if (!empty($_GET['condicao'])) {
    $sql .= " AND l.condicao = :condicao";
    $parametros[':condicao'] = $_GET['condicao'];
}

if (!empty($_GET['estado'])) {
    $sql .= " AND u.estado = :estado";
    $parametros[':estado'] = $_GET['estado'];
}

$sql .= " ORDER BY l.cadastrado_em DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($parametros);
$livros = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>