DROP DATABASE IF EXISTS Pasteleria;
CREATE DATABASE IF NOT EXISTS Pasteleria;
USE Pasteleria;

CREATE TABLE IF NOT EXISTS productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    precio DECIMAL(10, 2) NOT NULL,
    categoria VARCHAR(255),
    tipo VARCHAR(50),
    relleno VARCHAR(255),
    imagen VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    usuario VARCHAR(100) NOT NULL UNIQUE,
    contraseña VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id INT NOT NULL,
    producto_id INT NOT NULL,
    cantidad INT NOT NULL,
    FOREIGN KEY (cliente_id) REFERENCES clientes(id) ON DELETE CASCADE,
    FOREIGN KEY (producto_id) REFERENCES productos(id) ON DELETE CASCADE
);


CREATE TABLE IF NOT EXISTS administradorProducto (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_producto VARCHAR(50) NOT NULL,
    precio DECIMAL(10, 2) NOT NULL,
    categoria VARCHAR(255),
    imagen VARCHAR(255),
    tipo_producto VARCHAR(50),
    relleno VARCHAR(255)
);


INSERT INTO clientes (nombre, usuario, contraseña) 
VALUES ('Oc', 'admin', 'admin'),
       ('Olga', 'usuario', 'usuario');

INSERT INTO productos (nombre, precio, categoria, tipo, relleno, imagen) 
VALUES 
    ('Tarta chocolate', 20.00, 'Tartas', 'Tarta', 'Chocolate', '/Pasteleria_JulioGarcia/public/img/tarta-chocolate.jpg'),
    ('Croissant', 2.50, 'Pasteles', 'Croissant', 'Nutella', '/Pasteleria_JulioGarcia/public/img/Croisant.jpg'),
    ('Polvorones', 5.50, 'Galletas', 'Polvorón', 'Leche condensada', '/Pasteleria_JulioGarcia/public/img/polvorones.jpg'),
    ('Churros chocolate', 6.00, 'Fogones', 'Churro', 'Chocolate', '/Pasteleria_JulioGarcia/public/img/churros.jpg'),
    ('Galletas avena', 5.00, 'Galletas', 'Galleta', 'Avena', '/Pasteleria_JulioGarcia/public/img/galletas.jpg'),
    ('Bollo crema', 3.50, 'Bollos', 'Bollo', 'Crema', '/Pasteleria_JulioGarcia/public/img/bollocrema.jpg'),
    ('Palmera crema', 3.50, 'Pasteles', 'Palmera', 'Crema', '/Pasteleria_JulioGarcia/public/img/palmeracrema.jpg'),
    ('Palmera chocolate', 3.75, 'Pasteles', 'Palmera', 'Chocolate', '/Pasteleria_JulioGarcia/public/img/palmerachocolate.jpg'),
    ('Chocolate amargo', 2.00, 'Chocolate', 'Chocolate', 'Amargo', '/Pasteleria_JulioGarcia/public/img/chocolateamargo.jpg');

INSERT INTO administradorProducto (nombre_producto, precio, categoria, tipo_producto, relleno, imagen)
VALUES
    ('Donuts', 3.00, 'Dulces', 'Frito', 'Azúcar', '/Pasteleria_JulioGarcia/public/img/donut.jpg'),
    ('Cañas', 2.50, 'Dulces', 'Horneado', 'Crema', '/Pasteleria_JulioGarcia/public/img/caña.jpg'),
    ('Pastel de Belén', 4.50, 'Dulces', 'Horneado', 'Crema', '/Pasteleria_JulioGarcia/public/img/pastel.jpg'),
    ('Suso', 5.00, 'Dulces', 'Horneado', 'Crema', '/Pasteleria_JulioGarcia/public/img/suso.jpg'),
    ('Tocino de Cielo', 3.75, 'Dulces', 'Horneado', 'Yema', '/Pasteleria_JulioGarcia/public/img/tocino.jpg'),
    ('Tarta chocolate', 20.00, 'Tartas', 'Tarta', 'Chocolate', '/Pasteleria_JulioGarcia/public/img/tarta-chocolate.jpg'),
    ('Croissant', 2.50, 'Pasteles', 'Croissant', 'Nutella', '/Pasteleria_JulioGarcia/public/img/Croisant.jpg'),
    ('Polvorones', 5.50, 'Galletas', 'Polvorón', 'Leche condensada', '/Pasteleria_JulioGarcia/public/img/polvorones.jpg'),
    ('Churros chocolate', 6.00, 'Fogones', 'Churro', 'Chocolate', '/Pasteleria_JulioGarcia/public/img/churros.jpg'),
    ('Galletas avena', 5.00, 'Galletas', 'Galleta', 'Avena', '/Pasteleria_JulioGarcia/public/img/galletas.jpg'),
    ('Bollo crema', 3.50, 'Bollos', 'Bollo', 'Crema', '/Pasteleria_JulioGarcia/public/img/bollocrema.jpg'),
    ('Palmera crema', 3.50, 'Pasteles', 'Palmera', 'Crema', '/Pasteleria_JulioGarcia/public/img/palmeracrema.jpg'),
    ('Palmera chocolate', 3.75, 'Pasteles', 'Palmera', 'Chocolate', '/Pasteleria_JulioGarcia/public/img/palmerachocolate.jpg'),
    ('Chocolate amargo', 2.00, 'Chocolate', 'Chocolate', 'Amargo', '/Pasteleria_JulioGarcia/public/img/chocolateamargo.jpg');


-- Verificar los clientes insertados
SELECT * FROM clientes;

-- Verificar los productos insertados
SELECT * FROM productos;

-- Verificar los pedidos
SELECT 
    p.id AS pedido_id, 
    c.nombre AS cliente, 
    pr.nombre AS producto, 
    p.cantidad
FROM pedidos p
JOIN clientes c ON p.cliente_id = c.id
JOIN productos pr ON p.producto_id = pr.id;

-- Verificar los productos del administrador
SELECT * FROM administradorProducto;
