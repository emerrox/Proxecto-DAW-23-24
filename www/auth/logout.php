<?php
session_start();
session_destroy();
if (isset($_COOKIE)) {
    foreach ($_COOKIE as $name => $cookie) {
        setcookie($name,'', time() - 42000);
    }
}

header("Location: /");
exit();