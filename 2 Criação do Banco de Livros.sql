USE livr_ar;

CREATE TABLE livros (
    id_livro INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    titulo VARCHAR(255) NOT NULL,
    preco DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    genero ENUM('Mistério', 'Ficção Cientifica', 'Ação', 'Medieval', '') NOT NULL,
    condicao ENUM('Novo', 'Seminovo', 'Bom estado', 'Com marcas de uso', 'Danificado') NOT NULL,
    cadastrado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_usuario_livro FOREIGN KEY (id_usuario) REFERENCES usuarios (id) ON DELETE CASCADE
);

SELECT * FROM livros