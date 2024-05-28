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
    $sql = 'SELECT * FROM usuarios';
    $res = $conn->query($sql);

    
$rows = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
} else {
    echo "0 resultados";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultados de la Consulta</title>
</head>
<body>
    <h3>Resultados de la Consulta:</h3>
    <?php
    foreach ($rows as $row) {
        echo "ID: " . $row['id'] . "<br>";
        echo "Nombre: " . $row['nombre'] . "<br>";
        echo "Email: " . $row['email'] . "<br><br>";
    }
    ?>

    <h3>Dump de la Consulta:</h3>
    <pre>
    <?php var_dump($rows); ?>
    </pre>
<?php
    $conn->close();
}


include_once(__DIR__ . '/iniciar.php');