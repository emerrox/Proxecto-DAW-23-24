USE kayakplus;

-- Insertar usuarios
INSERT INTO usuarios (nombre, email, contraseña) VALUES
('User1', 'user1@example.com', 'abc123.'),
('User2', 'user2@example.com', 'abc123.'),
('User3', 'user3@example.com', 'abc123.'),
('User4', 'user4@example.com', 'abc123.'),
('User5', 'user5@example.com', 'abc123.');

-- Insertar deportistas
INSERT INTO deportistas (id, nivel) VALUES
(1, 'Avanzado'),
(2, 'Intermedio'),
(3, 'Principiante');

-- Insertar entrenadores
INSERT INTO entrenadores (id, especialidad) VALUES
(4, 'Kayak'),
(5, 'canoa');

-- Insertar grupos
INSERT INTO grupos (nombre, descripcion) VALUES
('Grupo A', 'Kayaks senior y juveniles'),
('Grupo B', 'Canoas cadetes');

-- Insertar relación grupo_deportistas
INSERT INTO grupo_deportistas (grupo_id, deportista_id) VALUES
(1, 1),
(1, 2),
(2, 3);

-- Insertar relación grupo_entrenadores
INSERT INTO grupo_entrenadores (grupo_id, entrenador_id) VALUES
(1, 4),
(2, 5);

-- Insertar entrenos
INSERT INTO entrenos (nombre, descripcion, fecha, duracion, grupo_id, entrenador_id) VALUES
('Entreno de velocidad', 'Entrenamiento intenso de velocidad en el agua', '2024-06-21', '01:00:00', 1, 4),
('Entreno de resistencia', 'Entrenamiento de resistencia y fondo', '2024-06-22', '02:00:00', 2, 5);