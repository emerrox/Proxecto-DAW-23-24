<?php
// si hay una sesion activa redirige a home y si no redirige a auth

if ($_SESSION['ok']) {
    header('Location: /home');
    exit();
}else{
    header('Location: /auth');
    exit();
}