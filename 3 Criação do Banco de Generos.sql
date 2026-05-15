USE livr_ar;

CREATE TABLE generos (
    id_genero INT AUTO_INCREMENT PRIMARY KEY,
    categoria ENUM('Gibi', 'Livro', 'Didádico', 'Revista') NOT NULL,
    genero VARCHAR(30) NOT NULL
);

SELECT * FROM generos;