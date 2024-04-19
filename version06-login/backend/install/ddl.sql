CREATE TABLE Usuario (
	id_usuario INT NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
	PRIMARY KEY(id_usuario)
);

CREATE TABLE Mensaje (
	id_mensaje INT NOT NULL AUTO_INCREMENT,
    id_usuario INT NOT NULL,
    cuerpo VARCHAR(255) NOT NULL,
    fecha DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY(id_mensaje),
    FOREIGN KEY (id_usuario) REFERENCES Usuario(id_usuario)
);

-- ALTER TABLE Usuario ADD nombre VARCHAR (255) NOT NULL DEFAULT "PERRO LOCO";
