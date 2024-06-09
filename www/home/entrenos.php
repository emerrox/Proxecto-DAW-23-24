<?php
session_start();
include('../utils/bd.php');
$conn = conectar_bd();
if ($_SERVER["REQUEST_METHOD"] == "GET"){
  $sql = "SELECT * FROM entrenos";
  $resultado = $conn->query($sql);
  
  $conn -> close();

  $entrenos = [];
  while ($fila = $resultado->fetch_assoc()) {

    foreach ($_SESSION['gDeportista'] as $grupo_id_deportista) {
      if ($grupo_id_deportista == $fila['grupo_id']) {
        $entrenos[] = [
            'id' => $fila['id'],
            'title' => $fila['nombre'],
            'start' => $fila['hora_inicio'],
            'end' => $fila['hora_fin'],
            'description' => $fila['descripcion'],
            'role' => 'deportista'
        ];
      }
    }

    foreach ($_SESSION['gEntrenador'] as $grupo_id_entrenador) {
      if ($grupo_id_entrenador == $fila['grupo_id']) {
        $entrenos[] = [
            'id' => $fila['id'],
            'title' => $fila['nombre'],
            'start' => $fila['hora_inicio'],
            'end' => $fila['hora_fin'],
            'description' => $fila['descripcion'],
            'role' => 'entrenador'
        ];
      }
    }
  }
  $json = json_encode($entrenos);
  header('Content-Type: application/json');
  echo $json;
}


// Verificar si se ha enviado un evento
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Obtener los datos del evento desde el cuerpo de la solicitud
    $event_data = json_decode(file_get_contents("php://input"), true);


    // Validar que se han recibido los datos esperados
    if (isset($event_data['title']) && isset($event_data['description']) && isset($event_data['start']) && isset($event_data['end']) ) {
        // Obtener los datos del evento
        $title = $event_data['title'];
        $description = $event_data['description'];
        $start = $event_data['start'];
        $end = $event_data['end'];
        $entrenador_id = $_SESSION['id'];
        $grupo_id = $event_data['grupoId'];
        
        // Preparar la consulta SQL para insertar el evento en la base de datos
        $sql = "INSERT INTO entrenos (nombre, descripcion, hora_inicio, hora_fin, grupo_id, entrenador_id) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssii", $title, $description, $start, $end, $grupo_id, $entrenador_id);
        $res = $stmt->execute();
        $stmt->close();
        $conn->close();
        // Ejecutar la consulta SQL
        if ($res) {
          $response = array("status" => "success", "message" => "Evento creado exitosamente");
          echo json_encode($response);
        } else {
          // Si hubo un error al insertar el evento, devuelve un mensaje de error
          $response = array("status" => "error", "message" => "Error al crear el evento");
          echo json_encode($response);
        }
        
        // Cerrar la conexión a la base de datos

    } else {
        // Si no se recibieron los datos esperados, devuelve un mensaje de error
        $response = array("statusText" => "error", "message" => "Datos del evento incompletos");
        echo json_encode($response);
    }

}

if ($_SERVER["REQUEST_METHOD"] == "PUT") {
  $event_data = json_decode(file_get_contents("php://input"), true);

  if (isset($_GET['id']) && isset($event_data['title']) && isset($event_data['description']) && isset($event_data['start']) && isset($event_data['end'])) {
      $id = $_GET['id'];
      $title = $event_data['title'];
      $description = $event_data['description'];
      $start = $event_data['start'];
      $end = $event_data['end'];
      $grupo_id = $event_data['grupoId'];

      $sql = "UPDATE entrenos SET nombre = ?, descripcion = ?, hora_inicio = ?, hora_fin = ?, grupo_id = ? WHERE id = ?";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("ssssii", $title, $description, $start, $end, $grupo_id, $id);
      $res = $stmt->execute();
      $stmt->close();
      $conn->close();

      if ($res) {
          $response = array("status" => "success", "message" => "Evento actualizado exitosamente");
          echo json_encode($response);
      } else {
          $response = array("status" => "error", "message" => "Error al actualizar el evento");
          echo json_encode($response);
      }
  } else {
      $response = array("status" => "error", "message" => "Datos del evento incompletos o ID no proporcionado");
      echo json_encode($response);
  }
}

if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
  $id = $_GET['id'];

  $sql = "DELETE FROM entrenos WHERE id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $id);
  $res = $stmt->execute();
  $stmt->close();
  $conn->close();

  if ($res) {
      $response = array("status" => "success", "message" => "Evento eliminado exitosamente");
  } else {
      $response = array("status" => "error", "message" => "Error al eliminar el evento");
  }

  echo json_encode($response);
}