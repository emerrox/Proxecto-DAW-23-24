<?php
// archivo para iniciar sesión
session_start();
include_once('../utils/bd.php');

$sql = "SELECT grupo_id FROM grupo_deportistas WHERE deportista_id=$id";
$res1 = $conn->query($sql);
$_SESSION['gDeportista'] = [];
while ($fila = $res1->fetch_assoc()) {
    $_SESSION['gDeportista'][]=$fila['grupo_id'];
  }

$sql2 = "SELECT grupo_id FROM grupo_entrenadores WHERE  entrenador_id=$id";
$res2 = $conn->query($sql2);
$_SESSION['gEntrenador'] = [];
while ($fila = $res2->fetch_assoc()) {
    $_SESSION['gEntrenador'][]=$fila['grupo_id'];
  }


$_SESSION['ok'] = true;
$_SESSION['user'] = $name;
$_SESSION['id'] = $id;
$conn -> close();


