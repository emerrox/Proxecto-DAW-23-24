<?php
// Si ya se inició sesión redirige a inicio
if ($_SESSION['ok']) {
    header('Location: ../home');
    exit();
}

// Precesar formulario
if (isset($_POST['ini'])){
    include_once('./procesar.php');
}

// mostrar formulario
header('Location: ./form_iniciar.php');
exit();