<?php
session_start();
include_once('../utils/bd.php');
include_once('../utils/funciones.php');
$conn = conectar_bd();

if (!empty($_POST['id']) && isset($_SESSION['id'])) {
    $usuario_id = clean_input($_SESSION['id']);
    $grupo_id = clean_input(intval($_POST['id'])); // Asegurarse de que el ID del grupo sea un número entero

    // Comprobar si el usuario ya pertenece al grupo como deportista o entrenador
    if (in_array($grupo_id, $_SESSION['gDeportista']) || in_array($grupo_id, $_SESSION['gEntrenador'])) {
        $conn->close();
        header("Location: grupo.php?gid=" . $grupo_id);
        exit;
    }

    // Verificar si el usuario es deportista
    $sql = "SELECT COUNT(*) AS count FROM deportistas WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $count_deportista = $row['count'];

    // Si el usuario no es deportista, añadirlo
    if ($count_deportista == 0) {
        $sql = "INSERT INTO deportistas (id, nivel) VALUES (?, 'Normal')";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $usuario_id);
        $stmt->execute();
    }

    // Añadir a grupo_deportistas
    $sql = "INSERT INTO grupo_deportistas (grupo_id, deportista_id) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $grupo_id, $usuario_id);
    $stmt->execute();

    // Actualizar la sesión del usuario
    $_SESSION['gDeportista'][] = $grupo_id;
}

$conn->close();
header("Location: grupo.php?gid=" . $grupo_id);
exit;
?>
