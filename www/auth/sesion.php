<?php
// archivo para iniciar sesión
session_start();
$_SESSION['ok'] = true;
$_SESSION['user'] = $name;