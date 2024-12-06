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
       ('Oc', 'usuario', 'usuario');

-- Insertar productos (dulces)
INSERT INTO productos (nombre, precio, categoria, tipo, relleno) 
VALUES 
    ('Tarta de chocolate', 20.00, 'Tartas', 'Tarta', 'Chocolate'),
    ('Galletas de avena', 5.00, 'Galletas', 'Galleta', 'Avena'),
    ('Bollo de crema', 3.50, 'Bollos', 'Bollo', 'Crema'),
    ('Chocolate amargo', 2.00, 'Chocolate', 'Chocolate', 'Amargo'),
    ('Tarta de frutas', 25.00, 'Tartas', 'Tarta', 'Frutas');


-- Verificar los clientes insertados
SELECT * FROM clientes;

-- Verificar los productos insertados
SELECT * FROM productos;

-- Verificar los pedidos
SELECT * FROM pedidos;
