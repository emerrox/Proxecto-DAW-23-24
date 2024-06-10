<?php include_once('../templates/cabecera.html'); ?>
<main>
<div class="container">
    <h2>Registro de Usuario</h2>
    <form id="registroForm" method="POST" action="procesar_registro.php">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>
        <div id="nombre-error" class="error-message"></div> <!-- Mensaje de error para el nombre -->
        <br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <div id="email-error" class="error-message"></div> <!-- Mensaje de error para el email -->
        <br><br>

        <label for="contrasena">Contraseña:</label>
        <input type="password" id="contrasena" name="contrasena" required>
        <div id="contrasena-error" class="error-message"></div> <!-- Mensaje de error para la contraseña -->
        <br><br>

        <button type="submit">Registrar</button>
    </form>
    <p class="minus"><a href="./form_iniciar.php">Iniciar sesión</a> si ya tienes una cuenta</p>
</div>
</main>
    <script src="../assets/js/auth_forms.js"></script>

<?php include_once('../templates/footer.html'); ?>
