<?php

// Funcion para limpiar datos de entrada
function clean_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data); 
    return $data;
}

// Si ya se inició sesión redirige a inicio
if ($_SESSION['ok']) {
    header('Location: ../home');
    exit();
}

// Precesar formulario
if (isset($_POST['ini'])){

    $name = clean_input($_POST['name']);
    $pass = clean_input($_POST['pass']);

    if ($name == '' || $pass == '') {
        header('Location: ./iniciar.php');
        exit();
    }

    include_once(__DIR__ . '/bd.php');
    $sql = $conn->prepare("SELECT id, nombre, email, contraseña FROM usuarios WHERE nombre = ?");
    $sql->bind_param("s", $name);
    $sql->execute();
    $res = $sql->get_result();

    $login_error="$name no está registrado";

    while ($user=$res->fetch_array()) {
        if ($user['nombre']==$name) {
            if ($user['contraseña']==$pass) {

                // codigo login correcto 

                $login_error='';
            }else{
                $login_error='contraseña incorrecta';
            }
        }
    }

    // session_start();
    $sql->close();
    $conn->close();
}


include_once(__DIR__ . '/iniciar.php');