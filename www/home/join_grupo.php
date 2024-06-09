<?php
session_start();
include_once('../utils/bd.php');
$conn = conectar_bd();
if (!empty($_POST['id'])) {
    $usuario_id = $_SESSION['id'];
    $grupo_id = $_POST['id'];
    // Verificar si el usuario es deportista
    $sql = "SELECT COUNT(*) AS count FROM deportistas WHERE id = $usuario_id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $count_deportista = $row['count'];
    
    // Si el usuario no es deportista, añadirlo
    if ($count_deportista == 0) {
        $sql = "INSERT INTO deportistas (id, nivel) VALUES ($usuario_id, 'Normal')";
        $conn->query($sql);
    }
    
    // Añadir a grupo_deportistas
    $sql = "INSERT INTO grupo_deportistas (grupo_id, deportista_id) VALUES ($grupo_id, $usuario_id)";
    $conn->query($sql);

    $_SESSION['gDeportista'][]=$grupo_id;
}
$conn->close();
header("Location: grupo.php?gid=" . $grupo_id);
exit;

