<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KayakPlus</title>
</head>
<body>
<?php echo $login_error ?>
<form action="./index.php" method="post">
<label for="name">Usuario</label>
<input type="text" id="name" name="name" required><br><br>

<label for="pass">Contraseña</label>
<input type="password" id="pass" name="pass" required><br><br>

<button type="submit" name="ini">Iniciar</button>
</form>
<a href="./form_registrar.php">Registrar</a> si aun no tienes una cuenta
</body>
</html>