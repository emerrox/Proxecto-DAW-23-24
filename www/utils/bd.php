<?php
/*
    $conn = new mysqli('localhost','root','','kayakplus');
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }
*/

function conectar_bd() {
    $conn = new mysqli('localhost', 'root', '', 'kayakplus');
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }
    return $conn;
}

function get_grupo($id){
    $conn = conectar_bd(); // Establece la conexión a la base de datos
    $sql = "SELECT * FROM grupos WHERE id=$id";
    $res = $conn->query($sql);
    
    $arr = [];
    
    while ($grupo = $res->fetch_assoc()){
        $arr['nombre'] = $grupo['nombre'];
        $arr['descripcion'] = $grupo['descripcion'];
    }
    $conn->close(); // Cierra la conexión
    return $arr;
}

function get_entrenadores_grupo($id) {
    $conn = conectar_bd(); 
    $sql = "SELECT u.id, u.nombre, u.email, e.especialidad
    FROM grupos g
    JOIN grupo_entrenadores ge ON g.id = ge.grupo_id
    JOIN entrenadores e ON ge.entrenador_id = e.id
    JOIN usuarios u ON e.id = u.id
    WHERE g.id = $id";
    $res = $conn->query($sql);

    $entrenadores = [];

    while ($entrenador = $res->fetch_assoc()) {
        $entrenadores[] = $entrenador;
    }
    $conn->close(); 
    return $entrenadores;
}

function get_deportistas_grupo($id) {
    $conn = conectar_bd(); 
    $sql = "SELECT u.id, u.nombre, u.email, d.nivel
    FROM grupos g
    JOIN grupo_deportistas gd ON g.id = gd.grupo_id
    JOIN deportistas d ON gd.deportista_id = d.id
    JOIN usuarios u ON d.id = u.id
    WHERE g.id = $id";
    $res = $conn->query($sql);

    $deportistas = [];

    while ($deportista = $res->fetch_assoc()) {
        $deportistas[] = $deportista;
    }
    $conn->close();
    return $deportistas;
}
