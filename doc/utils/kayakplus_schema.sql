-- kayakplus_schema.sql

-- Crear la base de datos y usarla
CREATE DATABASE kayakplus;
USE kayakplus;

-- tabla de usuarios
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    contraseña VARCHAR(100) NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- tabla de deportistas (generalización de usuarios)
CREATE TABLE deportistas (
    id INT PRIMARY KEY,
    nivel VARCHAR(50),
    FOREIGN KEY (id) REFERENCES usuarios(id)
);

-- tabla de entrenadores (generalización de usuarios)
CREATE TABLE entrenadores (
    id INT PRIMARY KEY,
    especialidad VARCHAR(100),
    FOREIGN KEY (id) REFERENCES usuarios(id)
);

-- tabla de grupos
CREATE TABLE grupos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT
);

-- tabla grupo_deportistas, relación deportistas a grupos
CREATE TABLE grupo_deportistas (
    grupo_id INT,
    deportista_id INT,
    PRIMARY KEY (grupo_id, deportista_id),
    FOREIGN KEY (grupo_id) REFERENCES grupos(id),
    FOREIGN KEY (deportista_id) REFERENCES deportistas(id)
);

-- tabla grupo_entrenadores, relación entrenadores a grupos
CREATE TABLE grupo_entrenadores (
    grupo_id INT,
    entrenador_id INT,
    PRIMARY KEY (grupo_id, entrenador_id),
    FOREIGN KEY (grupo_id) REFERENCES grupos(id),
    FOREIGN KEY (entrenador_id) REFERENCES entrenadores(id)
);

-- tabla de entrenos
CREATE TABLE entrenos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    fecha DATE NOT NULL,
    duracion TIME,
    grupo_id INT,
    entrenador_id INT,
    FOREIGN KEY (grupo_id) REFERENCES grupos(id),
    FOREIGN KEY (entrenador_id) REFERENCES entrenadores(id)
);
