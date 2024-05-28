<?php
if ($_SESSION['ok']) {
    
    header('Location: ../inicio.php');
    exit();

}

if (isset($_POST['ini'])){
    echo 'ini';
}


include_once(__DIR__ . '/iniciar.php');