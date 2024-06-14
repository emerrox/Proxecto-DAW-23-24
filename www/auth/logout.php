<?php
// archivo para borrar datos de la sesión y las cookies
session_start();
session_destroy();
if (isset($_COOKIE)) {
    foreach ($_COOKIE as $name => $cookie) {
        setcookie($name,'', time() - 42000);
    }
}

header("Location: ../");
exit();