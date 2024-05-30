<?php
// archivo que procesa el formulario

// Funcion para limpiar datos de entrada
function clean_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data); 
    return $data;
}


$name = clean_input($_POST['name']);
$pass = clean_input($_POST['pass']);

if (!($name == '' || $pass == '')) {

    // crea una conoxión con la base de datos
    include_once('./bd.php');

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
                include_once(__DIR__ . './sesion.php');
                header('Location: ../home');
                exit();

            }else{
                $login_error='contraseña incorrecta';
            }
        }
    }
    $sql->close();
    $conn->close();
}
