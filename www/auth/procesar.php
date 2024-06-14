<?php
include_once('../utils/bd.php');
include_once('../utils/funciones.php');
$conn = conectar_bd();

$name = clean_input($_POST['name']);
$pass = clean_input($_POST['pass']);

if (!($name == '' || $pass == '')) {

    // pide los datos del usuario que tenga el mismo nombre que el que se envió por el formulario
    $sql = $conn->prepare("SELECT id, nombre, email, contraseña FROM usuarios WHERE nombre = ?");
    $sql->bind_param("s", $name);
    $sql->execute();
    $res = $sql->get_result();

    $login_error="$name no está registrado";

    while ($user=$res->fetch_array()) {
        if ($user['nombre']==$name) {
            if ($user['contraseña']==$pass) {
                $login_error='';

                // guarda la info del usuario y redirige a home
                $id=$user['id'];
                include_once('./sesion.php');
                header('Location: ../home');
                exit();

            }else{
                $login_error='contraseña incorrecta';
            }
        }
    }
    if ($login_error!= '') {
        setcookie('error',$login_error,time() + 2);
    }
    $sql->close();
    $conn->close();
}
