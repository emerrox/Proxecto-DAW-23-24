<?php echo $login_error ?>
<form action="./index.php" method="post">
<label for="name">Usuario</label>
<input type="text" id="name" name="name" required><br><br>

<label for="pass">Contraseña</label>
<input type="password" id="pass" name="pass" required><br><br>

<button type="submit" name="ini">Iniciar</button>
</form>