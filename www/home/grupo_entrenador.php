<?php
include_once('../templates/cabecera.html');
echo "<h1>Administración de " . $grupo['nombre'] . "</h1>";
echo "<h2>" . $grupo['descripcion'] . "</h2>";
?>

<form id="administracion" method="POST" action="procesar_grupo_entrenador.php">

    <h3>Entrenadores</h3>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Especialidad</th>
                <th class="opc">Cambiar a Deportista</th>
                <th class="opc">Eliminar</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($entrenadores as $entrenador) {
                echo "<tr>";
                echo "<td>" . $entrenador['nombre'] . "</td>";
                echo "<td>" . $entrenador['especialidad'] . "</td>";
                echo "<td class="opc"><input type='checkbox' name='cambiar_entrenadores[]' value='" . $entrenador['id'] . "'></td>";
                echo "<td class="opc"><input type='checkbox' name='eliminar_entrenadores[]' value='" . $entrenador['id'] . "'></td>";
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
                <th class="opc">Cambiar a Entrenador</th>
                <th class="opc">Eliminar</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($deportistas as $deportista) {
                echo "<tr>";
                echo "<td>" . $deportista['nombre'] . "</td>";
                echo "<td>" . $deportista['nivel'] . "</td>";
                echo "<td class="opc"><input type='checkbox' name='cambiar_deportistas[]' value='" . $deportista['id'] . "'></td>";
                echo "<td class="opc"><input type='checkbox' name='eliminar_deportistas[]' value='" . $deportista['id'] . "'></td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
    
    <input type="hidden" name="grupo_id" value="<?php echo $gid; ?>">
    
    <button type="reset">Limpiar</button>
    <button type="submit">Guardar Cambios</button>
    <button id="botonBorrar">Borrar grupo</button>
    <dialog id="borrar">
            <h3>Seguro que quieres borrar el grupo</h3>
            <p>Este cambio es irreversible</p>
            <form action="procesar_grupo_entrenador.php" method="POST">
                <input type="hidden" name="grupo_id" value="<?php echo $gid; ?>">
                <input type="checkbox" id="confirmarBorrado">
                <label for="confirmarBorrado">Confirmar borrado</label><br>
                <button class="cerrar">Cancelar</button>
                <button type="submit" id="borrar2" name="borrar2" disabled >Borrar</button>
            </form>
    </dialog>
</form>
<script src="../assets/grupo.js"></script>
<?php include_once('../templates/footer.html'); ?>
