<?php
session_start();
include_once('../utils/bd.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = conectar_bd();

    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $usuario_id = $_SESSION['id'];

    // Validar entradas
    if (empty($nombre) || empty($descripcion)) {
        echo "Todos los campos son obligatorios.";
        exit;
    }

    // Insertar el nuevo grupo
    $sql = "INSERT INTO grupos (nombre, descripcion) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $nombre, $descripcion);
    $stmt->execute();

    // Obtener el último ID insertado
    $grupo_id = $conn->insert_id;

    // Comprobar si el usuario ya es entrenador
    $sql = "SELECT COUNT(*) AS count FROM entrenadores WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    if ($row['count'] == 0) {
        // Si el usuario no es entrenador, añadirlo a la tabla entrenadores
        $especialidad = 'General'; // O cualquier especialidad por defecto
        $sql = "INSERT INTO entrenadores (id, especialidad) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $usuario_id, $especialidad);
        $stmt->execute();
    }

    // Insertar el usuario como entrenador del nuevo grupo
    $sql = "INSERT INTO grupo_entrenadores (grupo_id, entrenador_id) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $grupo_id, $usuario_id);
    $stmt->execute();

    $stmt->close();
    $conn->close();

    // Agregar el grupo a la sesión
    $_SESSION['gEntrenador'][] = $grupo_id;
    // Redirigir al usuario a la página del nuevo grupo
    header("Location: grupo.php?gid=$grupo_id");
    exit();

}
?>
