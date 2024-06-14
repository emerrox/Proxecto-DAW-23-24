<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KayakPlus</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/tables.css">
</head>
<body>
    <header>
        <a href="../index.php"><p class="kayak" >kayak<span>+</span></p></a>
    </header>
    <div class="container">
<?php
echo "<h1>Administración de " . $grupo['nombre'] . " <span>" . $gid . "</span></h1>";
echo "<h2>" . $grupo['descripcion'] . "</h2>";
?>
<form id="administracion" method="POST" action="procesar_grupo_entrenador.php">

    <h3>Entrenadores</h3>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Especialidad</th>
                <th class="opc">Cambiar</th>
                <th class="opc">Eliminar</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($entrenadores as $entrenador) {
                echo "<tr>";
                echo "<td>" . $entrenador['nombre'] . "</td>";
                echo "<td>" . $entrenador['especialidad'] . "</td>";
                echo "<td class='opc'><input type='checkbox' name='cambiar_entrenadores[]' value='" . $entrenador['id'] . "'></td>";
                echo "<td class='opc'><input type='checkbox' name='eliminar_entrenadores[]' value='" . $entrenador['id'] . "'></td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

    <h3>Deportistas</h3>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Nivel</th>
                <th class="opc">Cambiar</th>
                <th class="opc">Eliminar</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($deportistas as $deportista) {
                echo "<tr>";
                echo "<td>" . $deportista['nombre'] . "</td>";
                echo "<td>" . $deportista['nivel'] . "</td>";
                echo "<td class='opc'><input type='checkbox' name='cambiar_deportistas[]' value='" . $deportista['id'] . "'></td>";
                echo "<td class='opc'><input type='checkbox' name='eliminar_deportistas[]' value='" . $deportista['id'] . "'></td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
    
    <input type="hidden" name="grupo_id" value="<?php echo $gid; ?>">
    
    <button type="reset">Limpiar</button>
    <button type="submit">Guardar Cambios</button>
    <button id="botonBorrar" class="peligro" >Borrar grupo</button>
</form>
    <dialog id="borrar">
    <span class="close-btn" id="cerrar" data-id="borrar">x</span>
            <h3>Seguro que quieres borrar el grupo</h3>
            <p>Este cambio es irreversible</p>
            <form action="procesar_grupo_entrenador.php" method="POST">
                <input type="hidden" name="grupo_id" value="<?php echo $gid; ?>">
                <div>
                    <input type="checkbox" id="confirmarBorrado">
                    <label for="confirmarBorrado">Confirmar borrado</label><br>

                </div>
                <button type="submit" id="borrar2" name="borrar2" class="peligro" disabled >Borrar</button>
            </form>
    </dialog>
</div>
<script src="../assets/js/grupo.js"></script>
<?php include_once('../templates/footer.html'); ?>
