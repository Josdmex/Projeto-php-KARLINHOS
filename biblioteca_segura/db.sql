CREATE DATABASE IF NOT EXISTS biblioteca DEFAULT CHARACTER SET utf8mb4;
USE biblioteca;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100),
    email VARCHAR(100),
    usuario VARCHAR(50),
    senha VARCHAR(255),
    nivel VARCHAR(20) DEFAULT 'comum'
);

CREATE TABLE livros (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(200),
    autor VARCHAR(150),
    categoria VARCHAR(100),
    ano INT,
    isbn VARCHAR(30),
    descricao TEXT,
    capa VARCHAR(300),
    disponivel TINYINT DEFAULT 1
);

CREATE TABLE emprestimos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    livro_id INT,
    leitor VARCHAR(120),
    data_emprestimo DATE,
    data_prevista DATE,
    devolvido TINYINT DEFAULT 0
);

-- Os usuários NÃO são criados aqui, para não gravar senha em texto puro.
-- Rode o setup.php uma vez pelo navegador para criar o admin com senha em hash.

INSERT INTO livros (titulo, autor, categoria, ano, isbn, descricao, capa, disponivel) VALUES
('Dom Casmurro', 'Machado de Assis', 'Romance', 1899, '9788535902778', 'A história de Bentinho e Capitu, com o ciúme como pano de fundo e a dúvida que nunca se resolve.', 'https://covers.openlibrary.org/b/isbn/9788535902778-L.jpg', 1),
('O Cortiço', 'Aluísio Azevedo', 'Naturalismo', 1890, '9788508133100', 'Retrato da vida em um cortiço no Rio de Janeiro do século XIX.', 'https://covers.openlibrary.org/b/isbn/9788508133100-L.jpg', 1),
('Capitães da Areia', 'Jorge Amado', 'Romance', 1937, '9788535911558', 'Meninos de rua em Salvador e a luta pela sobrevivência.', 'https://covers.openlibrary.org/b/isbn/9788535911558-L.jpg', 0),
('1984', 'George Orwell', 'Ficção', 1949, '9780451524935', 'Um regime totalitário que controla tudo, até o pensamento.', 'https://covers.openlibrary.org/b/isbn/9780451524935-L.jpg', 1),
('A Revolução dos Bichos', 'George Orwell', 'Fábula', 1945, '9788535909555', 'Animais tomam o controle de uma fazenda e o poder corrompe.', 'https://covers.openlibrary.org/b/isbn/9788535909555-L.jpg', 1),
('Vidas Secas', 'Graciliano Ramos', 'Regionalismo', 1938, '9788503012799', 'Uma família de retirantes enfrenta a seca no sertão nordestino.', 'https://covers.openlibrary.org/b/isbn/9788503012799-L.jpg', 1);
