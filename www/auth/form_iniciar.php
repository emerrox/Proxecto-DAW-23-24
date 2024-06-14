<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KayakPlus</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/form.css">
</head>
<body>
    <header>
        <a href="../index.php"><p class="kayak" >kayak<span>+</span></p></a>
    </header>
<main>
    <div class="container">
        <h2 class="mayus">Iniciar Sesión</h2>
        <?php 
        if (isset($_COOKIE['error'])) {
            echo $_COOKIE['error'];
        }
        ?>
        <form id="loginForm" action="./index.php" method="post">
            <label for="name">Usuario</label>
            <div class="error-message" id="name-error"></div>
            <input type="text" id="name" name="name" required>

            <label for="pass">Contraseña</label>
            <div class="error-message" id="pass-error"></div>
            <input type="password" id="pass" name="pass" required>

            <button type="submit" id="submitBtn" name="ini">Iniciar</button>
        </form>
        <p class="minus"><a href="./form_registrar.php">Registrar</a> si aún no tienes una cuenta</p>
    </div>
</main>

    <script src="../assets/js/auth_forms.js"></script>
<?php include_once('../templates/footer.html'); ?>

