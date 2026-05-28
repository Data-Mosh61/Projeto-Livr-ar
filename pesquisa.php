<?php

// 1. Inicializa a consulta base com JOIN. Buscamos colunas do livro (l), o estado do usuário (u) e o gênero (g)
$sql = "SELECT l.*, u.estado, g.categoria, g.genero AS genero
        FROM livros l 
        LEFT JOIN usuarios u ON l.id_usuario = u.id 
        LEFT JOIN generos g ON l.id_genero = g.id_genero 
        WHERE 1=1";

$parametros = [];

// 2. Aplicando Filtros se existirem na URL (via GET)
if (!empty($_GET['titulo'])) {
    $sql .= " AND l.titulo LIKE :titulo";
    $parametros[':titulo'] = '%' . $_GET['titulo'] . '%';
}

if (!empty($_GET['tipo'])) {
    $sql .= " AND g.tipo = :tipo";
    $parametros[':tipo'] = $_GET['tipo'];
}

if (!empty($_GET['categoria'])) {
    $sql .= " AND g.categoria = :categoria";
    $parametros[':categoria'] = $_GET['categoria'];
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
