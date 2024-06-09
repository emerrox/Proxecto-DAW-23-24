<?php
session_start();
include_once('../utils/bd.php');
$conn = conectar_bd();

if (isset($_POST)) {
    if (isset($_POST['grupo_id'])) {
        $sql = "DELETE FROM grupo_deportistas WHERE grupo_id = ? AND deportista_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $_POST['grupo_id'], $_SESSION['id']);
        $stmt->execute();
        $grupos = $_SESSION['gDeportista'];
        $_SESSION['gDeportista'] = [];
        foreach ($grupos as $key => $value) {
            if ($value != $_POST['grupo_id']) {
                $_SESSION['gDeportista'][]=$value;
            }
        }
    }
}

$stmt->close();
$conn->close();
header('Location: ../home');
exit();