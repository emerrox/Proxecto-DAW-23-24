USE kayakplus;

-- Insertar usuarios
INSERT INTO usuarios (nombre, email, contraseña) VALUES
('User1', 'user1@example.com', 'abc123.'),
('User2', 'user2@example.com', 'abc123.'),
('User3', 'user3@example.com', 'abc123.'),
('User4', 'user4@example.com', 'abc123.'),
('User5', 'user5@example.com', 'abc123.'),
('User6', 'user6@example.com', 'abc123.');

-- Insertar deportistas
INSERT INTO deportistas (id, nivel) VALUES
(1, 'Avanzado'),
(2, 'Intermedio'),
(3, 'Principiante');

-- Insertar entrenadores
INSERT INTO entrenadores (id, especialidad) VALUES
(4, 'Kayak'),
(5, 'Canoa'),
(6, 'Multidisciplinario');

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
(2, 5),
(1, 6), -- Usuario6 entrenando en Grupo A
(2, 6); -- Usuario6 entrenando en Grupo B

-- Insertar entrenos
INSERT INTO entrenos (nombre, descripcion, hora_inicio, hora_fin, grupo_id, entrenador_id, bloques) VALUES
('Entreno de velocidad', 'Entrenamiento intenso de velocidad en el agua', '2024-06-21T10:00:00', '2024-06-21T11:00:00', 1, 4,'[[{"ritmo":"r0","tipo":"metros","duracion":"4"}]]'),
('Entreno de resistencia', 'Entrenamiento de resistencia y fondo', '2024-06-22T09:00:00', '2024-06-22T11:00:00', 2, 5,'[[{"ritmo":"r4","tipo":"metros","duracion":"5"}]]');
