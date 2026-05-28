CREATE TABLE mensagens (
    id_mensagem INT AUTO_INCREMENT PRIMARY KEY,
    mensagem TEXT NOT NULL,
    remetente INT NOT NULL,
    recebedor INT NOT NULL,
    envio TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_usuario_remetente FOREIGN KEY (remetente) REFERENCES usuarios(id),
    CONSTRAINT fk_usuario_recebedor FOREIGN KEY (recebedor) REFERENCES usuarios(id)
);