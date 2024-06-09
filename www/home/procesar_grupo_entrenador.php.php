<?php
include_once('../utils/bd.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = conectar_bd();
    $grupo_id = $_POST['grupo_id'];
    if (isset($_POST['borrar2'])) {
        // Borrar las relaciones de entrenadores asociadas al grupo
        $sql = "DELETE FROM grupo_entrenadores WHERE grupo_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $grupo_id);
        $stmt->execute();
        
        // Borrar las relaciones de deportistas asociadas al grupo
        $sql = "DELETE FROM grupo_deportistas WHERE grupo_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $grupo_id);
        $stmt->execute();
        
        // Borrar el grupo en sí
        $sql = "DELETE FROM grupos WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $grupo_id);
        $stmt->execute();
        
        // Redirigir a una página después de borrar el grupo
        header("Location: ../home");
        exit;
    }
    
    // Procesar eliminaciones y cambios de entrenadores
    if (!empty($_POST['eliminar_entrenadores'])) {
        $eliminarIds = $_POST['eliminar_entrenadores'];
        foreach ($eliminarIds as $id) {
            $sql = "DELETE FROM grupo_entrenadores WHERE grupo_id = ? AND entrenador_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $grupo_id, $id);
            $stmt->execute();
        }
    }
    
    if (!empty($_POST['cambiar_deportistas'])) {
        $cambiarIds = $_POST['cambiar_deportistas'];
        foreach ($cambiarIds as $id) {
            echo $id;
            // Verificar si el usuario es entrenador
            $sql = "SELECT COUNT(*) AS count FROM entrenadores WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $count_entrenador = $row['count'];
            
            // Si el usuario no es entrenador, añadirlo
            if ($count_entrenador == 0) {
                $sql = "INSERT INTO entrenadores (id, especialidad) VALUES (?, 'General')";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $id);
                $stmt->execute();
            }

            // Eliminar de entrenadores
            $sql = "DELETE FROM grupo_entrenadores WHERE grupo_id = ? AND entrenador_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $grupo_id, $id);
            $stmt->execute();

            // Eliminar de deportistas
            $sql = "DELETE FROM grupo_deportistas WHERE grupo_id = ? AND deportista_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $grupo_id, $id);
            $stmt->execute();

            // Añadir a grupo_entrenadores
            $sql = "INSERT INTO grupo_entrenadores (grupo_id, entrenador_id) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $grupo_id, $id);
            $stmt->execute();
        }
    }
    
    // Procesar eliminaciones y cambios de deportistas
    if (!empty($_POST['eliminar_deportistas'])) {
        $eliminarIds = $_POST['eliminar_deportistas'];
        foreach ($eliminarIds as $id) {
            $sql = "DELETE FROM grupo_deportistas WHERE grupo_id = ? AND deportista_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $grupo_id, $id);
            $stmt->execute();
        }
    }

    if (!empty($_POST['cambiar_entrenadores'])) {
        $cambiarIds = $_POST['cambiar_entrenadores'];
        foreach ($cambiarIds as $id) {
            

            // Verificar si el usuario es deportista
            $sql = "SELECT COUNT(*) AS count FROM deportistas WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $count_deportista = $row['count'];
            
            // Si el usuario no es deportista, añadirlo
            if ($count_deportista == 0) {
                $sql = "INSERT INTO deportistas (id, nivel) VALUES (?, 'Normal')";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $id);
                $stmt->execute();
            }

            // Eliminar de deportistas
            $sql = "DELETE FROM grupo_deportistas WHERE grupo_id = ? AND deportista_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $grupo_id, $id);
            $stmt->execute();

            // Eliminar de entrenadores
            $sql = "DELETE FROM grupo_entrenadores WHERE grupo_id = ? AND entrenador_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $grupo_id, $id);
            $stmt->execute();

            // Añadir a grupo_deportistas
            $sql = "INSERT INTO grupo_deportistas (grupo_id, deportista_id) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $grupo_id, $id);
            $stmt->execute();
        }
    }
    
    $conn->close();
    header("Location: grupo.php?gid=" . $grupo_id);
    exit;
}
?>
