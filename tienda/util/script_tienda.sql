CREATE SCHEMA tienda_bd;
USE tienda_bd;

CREATE TABLE categorias (
	categoria VARCHAR(30) PRIMARY KEY,
    descripcion VARCHAR(255)
);

CREATE TABLE productos (
	id_producto INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(50),
    precio NUMERIC(6,2),
    categoria VARCHAR(30),
    stock INT DEFAULT 0,
    descripcion VARCHAR(255),
    FOREIGN KEY (categoria) REFERENCES categorias(categoria)
);

SELECT * FROM productos;
DELETE FROM productos;
DELETE FROM categorias;
SELECT * FROM categorias;

INSERT INTO categorias VALUES ('Juguete', 'objetos de ocio para menores');
INSERT INTO productos (nombre, precio, categoria, descripcion) 
	VALUES ('Barbie', 3, 'Juguete', 'Muñeca barbie');
    
commit;







