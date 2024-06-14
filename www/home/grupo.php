<?php
session_start();
include_once('../utils/bd.php');
include_once('../utils/funciones.php');
foreach ($_SESSION['gDeportista'] as $grupo => $id) {
    if (clean_input($_GET['gid']) == $id) {
        $gid=clean_input($_GET['gid']);
        $grupo = get_grupo($gid);
        $entrenadores = get_entrenadores_grupo($gid);
        $deportistas = get_deportistas_grupo($gid);
        include_once('./grupo_deportista.php');
    }
}

foreach ($_SESSION['gEntrenador'] as $grupo => $id) {
    if (clean_input($_GET['gid']) == $id) {
        $gid=clean_input($_GET['gid']);
        $grupo = get_grupo($gid);
        $entrenadores = get_entrenadores_grupo($gid);
        $deportistas = get_deportistas_grupo($gid);
        include_once('./grupo_entrenador.php');
    }
}
?>

