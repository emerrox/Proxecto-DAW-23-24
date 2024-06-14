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
    <h2>Registro de Usuario</h2>
    <form id="registroForm" method="POST" action="procesar_registro.php">
        <label for="nombre">Nombre:</label>
        <div id="nombre-error" class="error-message"></div> 
        <input type="text" id="nombre" name="nombre" required>

        <label for="email">Email:</label>
        <div id="email-error" class="error-message"></div>
        <input type="email" id="email" name="email" required>

        <label for="contrasena">Contraseña:</label>
        <div id="contrasena-error" class="error-message"></div> 
        <input type="password" id="contrasena" name="contrasena" required>

        <button type="submit">Registrar</button>
    </form>
    <p class="minus"><a href="./form_iniciar.php">Iniciar sesión</a> si ya tienes una cuenta</p>
</div>
</main>
    <script src="../assets/js/auth_forms.js"></script>

<?php include_once('../templates/footer.html'); ?>
