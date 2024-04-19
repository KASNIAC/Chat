CREATE TABLE mensaje (
	id_mensaje INT NOT NULL AUTO_INCREMENT,
    autor VARCHAR(30) NOT NULL DEFAULT "PERRO LOCO",
    cuerpo VARCHAR(255) NOT NULL,
    fecha DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY(id_mensaje)
);

-- SELECT * FROM mensaje;

-- INSERT INTO mensaje (autor, cuerpo) VALUES
-- ('KASNIAC', 'Este es un mensaje de prueba 1'),
-- ('Perro Loco', 'Este es un mensaje de prueba 2'),
-- ('KASNIAC', 'Este es un mensaje de prueba 3'),
-- ('Perro Loco', 'Este es un mensaje de prueba 4');

-- ALTER TABLE mensajes RENAME TO mensaje;
-- truncate mensaje;