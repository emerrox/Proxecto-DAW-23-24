<?php
session_start();
include_once('../utils/bd.php');
include_once('../utils/funciones.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = conectar_bd();

    $nombre = clean_input($_POST['nombre']);
    $descripcion = clean_input($_POST['descripcion']);
    $usuario_id = clean_input($_SESSION['id']);

    if (empty($nombre) || empty($descripcion)) {
        echo "Todos los campos son obligatorios.";
        exit;
    }

    $sql = "INSERT INTO grupos (nombre, descripcion) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $nombre, $descripcion);
    $stmt->execute();

    $grupo_id = $conn->insert_id;

    $sql = "SELECT COUNT(*) AS count FROM entrenadores WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    if ($row['count'] == 0) {
        $especialidad = 'General';
        $sql = "INSERT INTO entrenadores (id, especialidad) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $usuario_id, $especialidad);
        $stmt->execute();
    }

    $sql = "INSERT INTO grupo_entrenadores (grupo_id, entrenador_id) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $grupo_id, $usuario_id);
    $stmt->execute();

    $stmt->close();
    $conn->close();

    $_SESSION['gEntrenador'][] = $grupo_id;
    header("Location: grupo.php?gid=$grupo_id");
    exit();

}
?>
