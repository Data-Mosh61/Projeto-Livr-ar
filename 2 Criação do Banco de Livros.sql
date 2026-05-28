USE livr_ar;

CREATE TABLE livros (
    id_livro INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    id_genero INT NOT NULL,
    titulo VARCHAR(255) NOT NULL,
    preco DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    condicao ENUM('Novo', 'Seminovo', 'Bom estado', 'Com marcas de uso', 'Danificado') NOT NULL,
    disponibilidade INT NOT NULL DEFAULT 1,
    cadastrado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_usuario_livro FOREIGN KEY (id_usuario) REFERENCES usuarios (id) ON DELETE CASCADE,
    CONSTRAINT fk_livro_genero FOREIGN KEY (id_genero) REFERENCES generos (id_genero)
);

SELECT * FROM livros;
