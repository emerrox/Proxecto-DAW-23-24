<?php
session_start();  // Inicia la sesión
include_once('../utils/bd.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = conectar_bd();
    $grupo_id = $_POST['grupo_id'];
    
    if (isset($_POST['borrar2'])) {
        // Borrar las relaciones de entrenadores asociadas al grupo
        $sql = "DELETE FROM grupo_entrenadores WHERE grupo_id = $grupo_id";
        $conn->query($sql);
        
        // Borrar las relaciones de deportistas asociadas al grupo
        $sql = "DELETE FROM grupo_deportistas WHERE grupo_id = $grupo_id";
        $conn->query($sql);
        
        // Borrar el grupo en sí
        $sql = "DELETE FROM grupos WHERE id = $grupo_id";
        $conn->query($sql);
        
        // Redirigir a una página después de borrar el grupo
        header("Location: ../home");
        exit;
    }
    
    // Procesar eliminaciones y cambios de entrenadores
    if (!empty($_POST['eliminar_entrenadores'])) {
        $eliminarIds = $_POST['eliminar_entrenadores'];
        foreach ($eliminarIds as $id) {
            $sql = "DELETE FROM grupo_entrenadores WHERE grupo_id = $grupo_id AND entrenador_id = $id";
            $conn->query($sql);
        }
    }
    
    if (!empty($_POST['cambiar_entrenadores'])) {
        $cambiarIds = $_POST['cambiar_entrenadores'];
        foreach ($cambiarIds as $id) {
            // Verificar si el usuario es entrenador
            $sql = "SELECT COUNT(*) AS count FROM entrenadores WHERE id = $id";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            $count_entrenador = $row['count'];
            
            // Si el usuario no es entrenador, añadirlo
            if ($count_entrenador == 0) {
                $sql = "INSERT INTO entrenadores (id, especialidad) VALUES ($id, 'Especialidad por defecto')";
                $conn->query($sql);
            }

            // Eliminar de entrenadores
            $sql = "DELETE FROM grupo_entrenadores WHERE grupo_id = $grupo_id AND entrenador_id = $id";
            $conn->query($sql);

            // Eliminar de deportistas
            $sql = "DELETE FROM grupo_deportistas WHERE grupo_id = $grupo_id AND deportista_id = $id";
            $conn->query($sql);

            // Añadir a grupo_entrenadores
            $sql = "INSERT INTO grupo_entrenadores (grupo_id, entrenador_id) VALUES ($grupo_id, $id)";
            $conn->query($sql);
        }
    }
    
    // Procesar eliminaciones y cambios de deportistas
    if (!empty($_POST['eliminar_deportistas'])) {
        $eliminarIds = $_POST['eliminar_deportistas'];
        foreach ($eliminarIds as $id) {
            $sql = "DELETE FROM grupo_deportistas WHERE grupo_id = $grupo_id AND deportista_id = $id";
            $conn->query($sql);
        }
    }

    if (!empty($_POST['cambiar_deportistas'])) {
        $cambiarIds = $_POST['cambiar_deportistas'];
        foreach ($cambiarIds as $id) {
            // Verificar si el usuario es deportista
            $sql = "SELECT COUNT(*) AS count FROM deportistas WHERE id = $id";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            $count_deportista = $row['count'];

            // Si el usuario no es deportista, añadirlo
            if ($count_deportista == 0) {
                $sql = "INSERT INTO deportistas (id, nivel) VALUES ($id, 'Nivel por defecto')";
                $conn->query($sql);
            }

            // Eliminar de deportistas
            $sql = "DELETE FROM grupo_deportistas WHERE grupo_id = $grupo_id AND deportista_id = $id";
            $conn->query($sql);

            // Eliminar de entrenadores
            $sql = "DELETE FROM grupo_entrenadores WHERE grupo_id = $grupo_id AND entrenador_id = $id";
            $conn->query($sql);

            // Añadir a grupo_deportistas
            $sql = "INSERT INTO grupo_deportistas (grupo_id, deportista_id) VALUES ($grupo_id, $id)";
            $conn->query($sql);
        }
    }

    // Añadir un usuario a un grupo
    if (isset($_POST['unirseGrupo'])) {
        $grupo_id_unirse = $_POST['grupo_id_unirse'];
        $usuario_id = $_SESSION['usuario_id'];  // Usar el ID del usuario de la sesión

        // Verificar si el usuario es deportista
        $sql = "SELECT COUNT(*) AS count FROM deportistas WHERE id = $usuario_id";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $count_deportista = $row['count'];

        // Si el usuario no es deportista, añadirlo
        if ($count_deportista == 0) {
            $sql = "INSERT INTO deportistas (id, nivel) VALUES ($usuario_id, 'Nivel por defecto')";
            $conn->query($sql);
        }

        // Añadir a grupo_deportistas
        $sql = "INSERT INTO grupo_deportistas (grupo_id, deportista_id) VALUES ($grupo_id_unirse, $usuario_id)";
        $conn->query($sql);
    }

    $conn->close();
    header("Location: grupo.php?gid=" . $grupo_id);
    exit;
}
?>
