-- Criação da tabela de representantes de turma
CREATE TABLE `representantes_turma` (
  `id_representante_turma` int(11) NOT NULL AUTO_INCREMENT,
  `id_aluno` int(11) NOT NULL,
  `id_turma` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `data_inicio` date NOT NULL,
  `data_fim` date DEFAULT NULL,
  `status` enum('ativo','inativo') NOT NULL DEFAULT 'ativo',
  PRIMARY KEY (`id_representante_turma`),
  KEY `id_aluno` (`id_aluno`),
  KEY `id_turma` (`id_turma`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `fk_representante_aluno` FOREIGN KEY (`id_aluno`) REFERENCES `alunos` (`id_aluno`) ON DELETE CASCADE,
  CONSTRAINT `fk_representante_turma` FOREIGN KEY (`id_turma`) REFERENCES `turmas` (`id_turma`) ON DELETE CASCADE,
  CONSTRAINT `fk_representante_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Adiciona índice único para garantir que um aluno só seja representante de uma turma por vez
ALTER TABLE `representantes_turma`
ADD UNIQUE INDEX `idx_aluno_turma_ativa` (`id_aluno`, `id_turma`, `status`);

-- Adiciona índice único para garantir que um usuário só seja representante de uma turma por vez
ALTER TABLE `representantes_turma`
ADD UNIQUE INDEX `idx_usuario_turma_ativa` (`id_usuario`, `id_turma`, `status`);

-- Adiciona trigger para garantir que o aluno pertence à turma que está representando
DELIMITER //
CREATE TRIGGER `verifica_aluno_turma` BEFORE INSERT ON `representantes_turma`
FOR EACH ROW
BEGIN
    DECLARE aluno_pertence_turma INT;
    
    SELECT COUNT(*) INTO aluno_pertence_turma
    FROM alunos
    WHERE id_aluno = NEW.id_aluno AND id_turma = NEW.id_turma;
    
    IF aluno_pertence_turma = 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'O aluno deve pertencer à turma que está representando';
    END IF;
END//
DELIMITER ; 