CREATE DATABASE IF NOT EXISTS restaurante;
USE restaurante;

CREATE TABLE reservaciones (
id INT PRIMARY KEY AUTO_INCREMENT,
nombre_cliente VARCHAR(200) NOT NULL,
fecha DATETIME NOT NULL,
num_personas INT NOT NULL,
clave VARCHAR(255) NOT NULL
);

DROP TABLE reservaciones;