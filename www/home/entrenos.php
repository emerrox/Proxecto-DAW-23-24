<?php
session_start();
include_once('../utils/bd.php');
include_once('../utils/funciones.php');
$conn = conectar_bd();

// Manejo de peticiones GET para obtener eventos
if ($_SERVER["REQUEST_METHOD"] == "GET"){
    $sql = "SELECT * FROM entrenos";
    $resultado = $conn->query($sql);
    
    $entrenos = [];
    while ($fila = $resultado->fetch_assoc()) {
        // Verificar si el usuario es deportista en algún grupo asociado al entrenamiento
        foreach ($_SESSION['gDeportista'] as $grupo_id_deportista) {
            if ($grupo_id_deportista == $fila['grupo_id']) {
                $entrenos[] = [
                    'id' => $fila['id'],
                    'title' => $fila['nombre'],
                    'start' => $fila['hora_inicio'],
                    'end' => $fila['hora_fin'],
                    'description' => $fila['descripcion'],
                    'role' => 'deportista',
                    'bloques' => $fila['bloques']
                ];
                break; // Salir del bucle una vez encontrado el grupo
            }
        }

        // Verificar si el usuario es entrenador en algún grupo asociado al entrenamiento
        foreach ($_SESSION['gEntrenador'] as $grupo_id_entrenador) {
            if ($grupo_id_entrenador == $fila['grupo_id']) {
                $entrenos[] = [
                    'id' => $fila['id'],
                    'title' => $fila['nombre'],
                    'start' => $fila['hora_inicio'],
                    'end' => $fila['hora_fin'],
                    'description' => $fila['descripcion'],
                    'role' => 'entrenador',
                    'bloques' => $fila['bloques']
                ];
                break; // Salir del bucle una vez encontrado el grupo
            }
        }
    }

    // Convertir el array de eventos a formato JSON y enviarlo como respuesta
    $json = json_encode($entrenos);
    header('Content-Type: application/json');
    echo $json;

    // Cerrar conexión a la base de datos
    $conn->close();
}

// Manejo de peticiones POST para crear nuevos eventos de entrenamiento
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del evento desde el cuerpo de la solicitud
    $event_data = json_decode(file_get_contents("php://input"), true);

    if (isset($event_data['title']) && isset($event_data['description']) && isset($event_data['start']) && isset($event_data['end']) && isset($event_data['grupoId'])) {
        $title = clean_input($event_data['title']);
        $description = clean_input($event_data['description']);
        $start = clean_input($event_data['start']);
        $end = clean_input($event_data['end']);
        $grupo_id = clean_input($event_data['grupoId']);
        $entrenador_id = $_SESSION['id']; 
        $bloques = $event_data['bloques'];
        // Preparar la consulta SQL para insertar el evento en la base de datos
        $sql = "INSERT INTO entrenos (nombre, descripcion, hora_inicio, hora_fin, grupo_id, entrenador_id, bloques) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssiis", $title, $description, $start, $end, $grupo_id, $entrenador_id, $bloques);
        $res = $stmt->execute();
        $stmt->close();

        // Enviar respuesta JSON según el resultado de la consulta
        if ($res) {
            $response = array("status" => "success", "message" => "Evento creado exitosamente");
        } else {
            $response = array("status" => "error", "message" => "Error al crear el evento");
        }
        echo json_encode($response);
    } else {
        // Si no se recibieron los datos esperados, devuelve un mensaje de error
        $response = array("status" => "error", "message" => "Datos del evento incompletos");
        echo json_encode($response);
    }

    // Cerrar conexión a la base de datos
    $conn->close();
}

// Manejo de peticiones PUT para actualizar eventos de entrenamiento
if ($_SERVER["REQUEST_METHOD"] == "PUT") {
    $event_data = json_decode(file_get_contents("php://input"), true);

    // Validar que se han recibido los datos esperados
    if (isset($_GET['id']) && isset($event_data['title']) && isset($event_data['description']) && isset($event_data['start']) && isset($event_data['end']) && isset($event_data['grupoId'])) {
        $id = clean_input($_GET['id']);
        $title = clean_input($event_data['title']);
        $description = clean_input($event_data['description']);
        $start = clean_input($event_data['start']);
        $end = clean_input($event_data['end']);
        $grupo_id = clean_input($event_data['grupoId']);
        $bloques = $event_data['bloques'];

        // Preparar la consulta SQL para actualizar el evento en la base de datos
        $sql = "UPDATE entrenos SET nombre = ?, descripcion = ?, hora_inicio = ?, hora_fin = ?, grupo_id = ?, bloques = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssisi", $title, $description, $start, $end, $grupo_id, $bloques, $id);
        $res = $stmt->execute();
        $stmt->close();

        // Enviar respuesta JSON según el resultado de la consulta
        if ($res) {
            $response = array("status" => "success", "message" => "Evento actualizado exitosamente");
        } else {
            $response = array("status" => "error", "message" => "Error al actualizar el evento");
        }
        echo json_encode($response);
    } else {
        // Si no se recibieron los datos esperados, devuelve un mensaje de error
        $response = array("status" => "error", "message" => "Datos del evento incompletos o ID no proporcionado");
        echo json_encode($response);
    }

    // Cerrar conexión a la base de datos
    $conn->close();
}

// Manejo de peticiones DELETE para eliminar eventos de entrenamiento
if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
    // Validar que se ha proporcionado un ID válido
    if (isset($_GET['id'])) {
        $id = clean_input($_GET['id']);

        // Preparar la consulta SQL para eliminar el evento de la base de datos
        $sql = "DELETE FROM entrenos WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $res = $stmt->execute();
        $stmt->close();

        // Enviar respuesta JSON según el resultado de la consulta
        if ($res) {
            $response = array("status" => "success", "message" => "Evento eliminado exitosamente");
        } else {
            $response = array("status" => "error", "message" => "Error al eliminar el evento");
        }
        echo json_encode($response);
    } else {
        // Si no se recibió un ID válido, devuelve un mensaje de error
        $response = array("status" => "error", "message" => "ID del evento no proporcionado");
        echo json_encode($response);
    }

    // Cerrar conexión a la base de datos
    $conn->close();
}
?>
