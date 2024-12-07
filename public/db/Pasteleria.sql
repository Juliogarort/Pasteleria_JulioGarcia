DROP DATABASE IF EXISTS Pasteleria;
CREATE DATABASE IF NOT EXISTS Pasteleria;
USE Pasteleria;

-- Creación tabla de productos
CREATE TABLE IF NOT EXISTS productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    precio DECIMAL(10, 2) NOT NULL,
    categoria VARCHAR(255),
    tipo VARCHAR(50), -- Nueva columna para el tipo de dulce
    relleno VARCHAR(255) -- Nueva columna para el relleno (si aplica)
);

-- Creación tabla de clientes
CREATE TABLE IF NOT EXISTS clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    usuario VARCHAR(100) NOT NULL UNIQUE,
    contraseña VARCHAR(255) NOT NULL
);


-- Creación tabla de pedidos
CREATE TABLE IF NOT EXISTS pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id INT NOT NULL,
    producto_id INT NOT NULL,
    cantidad INT NOT NULL,
    FOREIGN KEY (cliente_id) REFERENCES clientes(id) ON DELETE CASCADE,
    FOREIGN KEY (producto_id) REFERENCES productos(id) ON DELETE CASCADE
);

-- Insertar clientes
INSERT INTO clientes (nombre, usuario, contraseña) 
VALUES ('admin', 'admin', 'admin'),
       ('Olga', 'usuario', 'usuario');

-- Insertar productos (dulces)
INSERT INTO productos (nombre, precio, categoria, tipo, relleno) 
VALUES 
    ('Tarta chocolate', 20.00, 'Tartas', 'Tarta', 'Chocolate'),
	('Croissant', 2.50, 'Pasteles', 'Croissant', 'Nutella'),
    ('Polvorones', 5.50, 'Galletas', 'Polvorón', 'Leche condensada'),
    ('Churros chocolate', 6.00, 'Fogones', 'Churro', 'Chocolate'),
    ('Galletas avena', 5.00, 'Galletas', 'Galleta', 'Avena'),
    ('Bollo crema', 3.50, 'Bollos', 'Bollo', 'Crema'),
    ('Palmera crema', 3.50, 'Pasteles', 'Palmera', 'Crema'),
    ('Palmera chocolate', 3.75, 'Pasteles', 'Palmera', 'Chocolate'),
    ('Chocolate amargo', 2.00, 'Chocolate', 'Chocolate', 'Amargo'),
    ('Tarta frutas', 25.00, 'Tartas', 'Tarta', 'Frutas');


-- Verificar los clientes insertados
SELECT * FROM clientes;

-- Verificar los productos insertados
SELECT * FROM productos;

-- Verificar los pedidos
SELECT * FROM pedidos;
