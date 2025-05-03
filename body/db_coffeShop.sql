Create Database CoffeeShop;
use CoffeeShop;
-- tabla admin 
CREATE TABLE usuarios (
	id INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(20) NOT NULL UNIQUE,
    Correo VARCHAR(100) NOT NULL,
    Clave VARCHAR(255) NOT NULL
    -- encriptar clave password_hash php
);
ALTER TABLE usuarios
ADD COLUMN rol ENUM('admin', 'usuario', 'trabajador') NOT NULL DEFAULT 'usuario';
-- insertar el usuario admin por db
-- clave $2y$10$Rx55bVpXJf9Dz0BetNS2UumodNOIL3zQzcf/oTqvsSlc1tuTws5DS 
-- el admin con este uestado admin
select * from usuarios;
UPDATE usuarios
SET rol = 'admin'
WHERE id = 1;

-- Categoria
CREATE TABLE categorias (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nombre_categoria VARCHAR(50) NOT NULL
);
--
ALTER TABLE categorias ADD estado TINYINT(1) NOT NULL DEFAULT 1;
--
-- productos
CREATE TABLE productos (
  id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(255) NOT NULL,
  descripcion TEXT NOT NULL,
  precio_normal DECIMAL(10,2) NOT NULL,
  precio_rebajado DECIMAL(10,2),
  cantidad INT(11) NOT NULL,
  imagen VARCHAR(100) NOT NULL,
  id_categoria INT(11) NOT NULL,
  FOREIGN KEY (id_categoria) REFERENCES categorias(id) ON DELETE CASCADE
);
--
ALTER TABLE productos ADD estado TINYINT(1) NOT NULL DEFAULT 1;
--
-- tabla clientes 
CREATE TABLE clientes (
  id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100),
  correo VARCHAR(100) NOT NULL UNIQUE,
  fecha_registro DATETIME DEFAULT CURRENT_TIMESTAMP
);
-- RESERCA
CREATE TABLE reservas (
  id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  nombre_cliente VARCHAR(100) NOT NULL,
  correo_cliente VARCHAR(100) NOT NULL,
  fecha_reserva DATE NOT NULL,
  hora_reserva TIME NOT NULL,
  id_producto INT(11) NOT NULL,
  estado VARCHAR(20) DEFAULT 'pendiente', -- Pendiente, Confirmada, Cancelada
  FOREIGN KEY (id_producto) REFERENCES productos(id) ON DELETE CASCADE
);
-- MENSAJE DE CONTACTO
CREATE TABLE mensajes_contacto (
  id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  correo VARCHAR(100) NOT NULL,
  asunto VARCHAR(150) NOT NULL,
  mensaje TEXT NOT NULL,
  fecha_envio DATETIME DEFAULT CURRENT_TIMESTAMP
);
-- datos
select * from mensajes_contacto;
select * from categorias;
select * from productos;
select * from clientes;
DROP TRIGGER IF EXISTS actualizar_estado_producto;
--
-- clave P


