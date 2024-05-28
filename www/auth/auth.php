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

    echo('bieeeeen');
    
    // session_start();
}


include_once(__DIR__ . '/iniciar.php');