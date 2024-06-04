<?php

include_once('../utils/bd.php')
$sql = "SELECT * FROM entrenos";
$resultado = $conn->query($sql);
$conn -> close();

$entrenos = [];
while ($fila = $resultado->fetch_assoc()) {
  $entrenos = [
      'id' => $fila['id'],
      'title' => $fila['nombre'],
      'start' => $fila['hora_inicio'],
      'end' => $fila['hora_fin'],
      'desc' => $fila['descripcion']
  ];
}

$json = json_encode($entrenos);
header('Content-Type: application/json');
echo $json;