-- Criar o banco de dados
CREATE DATABASE IF NOT EXISTS rlc_db;
USE rlc_db;

-- Criar as tabelas
CREATE TABLE usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL,
    nivel_acesso ENUM('adm', 'representante', 'pedagogo', 'coordenador') NOT NULL
);

CREATE TABLE turmas (
    id_turma INT AUTO_INCREMENT PRIMARY KEY,
    nome_turma VARCHAR(100) NOT NULL,
    ano INT NOT NULL,
    id_coordenador INT,
    FOREIGN KEY (id_coordenador) REFERENCES usuarios(id_usuario)
);

CREATE TABLE alunos (
    id_aluno INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    id_turma INT,
    FOREIGN KEY (id_turma) REFERENCES turmas(id_turma)
);

CREATE TABLE registros_presenca (
    id_registro INT AUTO_INCREMENT PRIMARY KEY,
    id_aluno INT,
    id_turma INT,
    data DATE NOT NULL,
    status ENUM('presente', 'atrasado', 'saiu_antecipado', 'falta') NOT NULL,
    observacao TEXT,
    FOREIGN KEY (id_aluno) REFERENCES alunos(id_aluno),
    FOREIGN KEY (id_turma) REFERENCES turmas(id_turma)
);

CREATE TABLE logs_acesso (
    id_log INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT,
    data_acesso DATETIME NOT NULL,
    acao_realizada TEXT NOT NULL,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
);

-- Inserir usuários iniciais com senhas válidas
-- admin@rlc.com
-- Senha: admin123
-- pedagogo@rlc.com
-- Senha: pedagogo123
-- representante@rlc.com
-- Senha: representante123
-- coordenador@rlc.com
-- Senha: coordenador123
