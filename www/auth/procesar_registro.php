<?php
include_once('../utils/bd.php');
$conn = conectar_bd();
if (isset($_POST)) {
    $sql = $conn->prepare("INSERT INTO usuarios (nombre, email, contraseña) VALUES(?,?,?)");
    $sql->bind_param("sss", $_POST['nombre'],$_POST['email'],$_POST['contrasena']);
    $sql->execute();

    $id=$conn->insert_id;
    include_once('./sesion.php');
    header('Location: ../home');
    exit();

}