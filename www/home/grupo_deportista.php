<?php
include_once('../templates/cabecera.html');
echo "<h1>" . $grupo['nombre'] . "</h1>";
echo "<h2>" . $grupo['descripcion'] . "</h2>";
?>

    <h3>Entrenadores</h3>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Especialidad</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($entrenadores as $entrenador) {
                echo "<tr>";
                echo "<td>" . $entrenador['nombre'] . "</td>";
                echo "<td>" . $entrenador['especialidad'] . "</td>";
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
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($deportistas as $deportista) {
                echo "<tr>";
                echo "<td>" . $deportista['nombre'] . "</td>";
                echo "<td>" . $deportista['nivel'] . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

<form action="salir.php" method="POST">
    <input type="hidden" name="grupo_id" id="grupo_id" value=<?php echo $gid; ?>>
    <button type="submit" id="salir" name="salir" >Salir del grupo</button>
</form>
<?php include_once('../templates/footer.html'); ?>
