CREATE SCHEMA biblioteca;


USE biblioteca;


CREATE  TABLE `biblioteca`.`livro` (
  `id_livro` INT NOT NULL AUTO_INCREMENT ,
  `nome` VARCHAR(45) NULL ,
  `autor` VARCHAR(45) NULL ,
  `genero` VARCHAR(45) NULL ,
  PRIMARY KEY (`id_livro`) );


CREATE  TABLE `biblioteca`.`cliente` (
  `id_cliente` INT NOT NULL AUTO_INCREMENT ,
  `nome` VARCHAR(45) NULL ,
  `cpf` VARCHAR(45) NULL ,
  `idade` INT NULL ,
  `username` VARCHAR(45) NULL ,
  `password` TEXT NULL ,
  PRIMARY KEY (`id_cliente`) );


CREATE  TABLE `biblioteca`.`aluguel` (
  `id_aluguel` INT NOT NULL AUTO_INCREMENT ,
  `id_cliente` INT NULL ,
  `id_livro` INT NULL ,
  `dia_aluguel` DATE NULL ,
  `dia_devolucao` DATE NULL ,
  PRIMARY KEY (`id_aluguel`) );


INSERT INTO livro ( `nome`, `autor`, `genero` ) 
VALUES 
	( 'A grande mortandade', 'John Kelly', 'Terror' ),
	( 'Mindset', 'Carol S. Dweck', 'Autoajuda' ),
	( 'Tom Ford', 'Anna Wintour', 'Suspense' ),
	( 'Por Que Lutamos', 'Manuela Davila', 'Contos' ),
	( 'Poderoso Destino', 'J. Marquesi', 'Suspense' );


INSERT INTO cliente ( `nome`, `idade`, `cpf`, `username`, `password` ) 
VALUES 
	( 'Igor', 22, '123.456.789-10', 'igor', 'pbkdf2:sha256:50000$QORg8kWg$c16951d03e74255ed03ffc76ed9fdbf6d77dddfcef4645f5236cdc1f9b4dd981' ),
	( 'Rodrigo', 23, '123.456.789-10', 'rodrigo', 'pbkdf2:sha256:50000$UPLzzlhC$379ac54200cdce25556b3a37e8c166661389451ff2ea88fcea2ffb18924bf5e8' ),
	( 'Tiago', 30, '123.456.789-10', 'tiago', 'pbkdf2:sha256:50000$53QMpugF$6cf5af689c2c0e38e01f244d0713791966332a94efd8117d00f459dab47c3c38' ),
	( 'Ricardo', 22, '123.456.789-10', 'ricardo', 'pbkdf2:sha256:50000$IXx1yUGR$c900e126240033a28edc33663d25e6223ff4fecb1aa608849120f23fe58646d6' ),
	( 'Paulo', 22, '123.456.789-10', 'paulo', 'pbkdf2:sha256:50000$Uew2zDhw$72b7ad65f12bd4ccef67656f0b71ca83af155ae38f01aa3b80f02d3c542e6026' );


INSERT INTO aluguel ( `id_cliente`, `id_livro`, `dia_aluguel`, `dia_devolucao` ) 
VALUES 
	( 2, 2, '2019-10-10', '2019-10-17' ),
	( 2, 3, '2019-10-10', '2019-10-17' ),
	( 3, 2, '2019-10-10', '2019-10-17' );














