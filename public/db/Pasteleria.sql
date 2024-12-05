DROP DATABASE IF EXISTS Pasteleria;
CREATE DATABASE IF NOT EXISTS Pasteleria;
USE Pasteleria;

-- creación tabla de productos 
CREATE TABLE IF NOT EXISTS productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    precio DECIMAL(10, 2) NOT NULL,
    categoría VARCHAR(255)
);

-- creación tabla de clientes 
CREATE TABLE IF NOT EXISTS clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    usuario VARCHAR(100) NOT NULL UNIQUE,
    contraseña VARCHAR(255) NOT NULL
);

-- creación tabla de pedidos 
CREATE TABLE IF NOT EXISTS pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id INT NOT NULL,
    producto_id INT NOT NULL,
    cantidad INT NOT NULL,
    FOREIGN KEY (cliente_id) REFERENCES clientes(id) ON DELETE CASCADE,
    FOREIGN KEY (producto_id) REFERENCES productos(id) ON DELETE CASCADE
);

-- Inserción de datos en la tabla champ
INSERT INTO champ (name, rol, difficulty, description) VALUES
('Ahri', 'Mago', '2', 'Maga que encanta a los enemigos y los asesina.'),
('Ashe', 'Tirador', '1', 'Arquera que ralentiza y congela a sus enemigos.'),
('Lee Sin', 'Luchador', '3', 'Monje ciego con movilidad y gran habilidad.'),
('Darius', 'Luchador', '2', 'Guerrero que ejecuta enemigos con su guadaña.'),
('Jinx', 'Tirador', '2', 'Tiradora caótica con explosivos y ametralladora.');


-- creación de la tabla user
CREATE TABLE IF NOT EXISTS user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL
);
