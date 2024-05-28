<?php
    $conn = new mysqli('localhost','root','','kayakplus');
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }