<?php
session_start();
include_once('../utils/bd.php');
$conn = conectar_bd();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kayakplus</title>
    <script src="../lib/fullcalendar-6.1.13/dist/index.global.js"></script>
    <script src="../lib/fullcalendar-6.1.13/packages/core/locales/es.global.js"></script>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">
<link rel="stylesheet" href="../assets/css/styles.css">
<link rel="stylesheet" href="../assets/css/form.css">

</head>
<body>
<header>
        <a href="../index.php"><p class="kayak" >kayak<span>+</span></p></a>
    </header>
    <div id="calendario"></div>

    <h2 class="encabezado">Tus grupos</h2>
    <div id="grupos">
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Rol</th>
                    <th>Entrenador</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Añadir filas por grupos del que es entrenador
                foreach ($_SESSION['gEntrenador'] as $gid) {
                    $grupo = get_grupo($gid); // Obtener la información del grupo mediante la función

                    if ($grupo) { // Verificar si se obtuvo información del grupo
                        $nombre = $grupo['nombre'];
                        $descripcion = $grupo['descripcion'];
                        $grupoId = $gid;
                        echo "<tr>";
                        echo "<td><a href='grupo.php?gid=$grupoId'>$nombre</a></td>";
                        echo "<td>$descripcion</td>";
                        echo "<td>Entrenador</td>";
                        echo "<td>";

                        $entrenadores = get_entrenadores_grupo($grupoId); // Obtener la lista de entrenadores
                        foreach ($entrenadores as $entrenador) {
                            echo $entrenador['nombre'] . " ";
                        }

                        echo "</td>";
                        echo "</tr>";
                    }
                }

                // Añadir filas por grupos del que es deportista
                foreach ($_SESSION['gDeportista'] as $gid) {
                    $grupo = get_grupo($gid); // Obtener la información del grupo mediante la función

                    if ($grupo) { // Verificar si se obtuvo información del grupo
                        $nombre = $grupo['nombre'];
                        $descripcion = $grupo['descripcion'];
                        $grupoId = $gid;
                        echo "<tr>";
                        echo "<td><a href='grupo.php?gid=$grupoId'>$nombre</a></td>";
                        echo "<td>$descripcion</td>";
                        echo "<td>Deportista</td>";
                        echo "<td>";

                        $entrenadores = get_entrenadores_grupo($grupoId); // Obtener la lista de entrenadores
                        foreach ($entrenadores as $entrenador) {
                            echo $entrenador['nombre'] . " ";
                        }

                        echo "</td>";
                        echo "</tr>";
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
    <div id="botones">
        <button id="add_grupo">Crear grupo</button>
        <button id="join_grupo">Unirse a grupo</button>

    </div>     


    <!-- Modal para mostrar formulario de unirse a grupo -->
    <dialog id="joinGrupo">
    <span class="close-btn" id="closejoinGrupo" data-id="joinGrupo">x</span>
        <form id="joinGrupoForm" method="POST" action="join_grupo.php">
            <h2>Unirse a nuevo grupo</h2>
            
            <label for="id">Código del grupo:</label>
            <div id="idJoinGrupo-error" class="error-message"></div> 
            <input type="number" id="idJoinGrupo" name="id" required><br><br>

            <button type="submit">Unirse</button>
        </form>
    </dialog>

    <!-- Modal para mostrar formulario de crear grupo -->
    <dialog id="crearGrupo">
    <span class="close-btn" id="closeCrearGrupo" data-id="crearGrupo">x</span>
        <form id="crearGrupoForm" method="POST" action="nuevo_grupo.php">
            <h2>Crear Nuevo Grupo</h2>
            
            <label for="nombre">Nombre:</label>
            <div id="nombreCrearGrupo-error" class="error-message"></div> 
            <input type="text" id="nombreCrearGrupo" name="nombre" required><br><br>

            <label for="descripcion">Descripción:</label>
            <textarea id="descripcionCrearGrupo" name="descripcion" required></textarea><br><br>

            <button type="submit">Crear Grupo</button>
        </form>
    </dialog>

    <!-- Modal para mostrar la información del evento -->
    <dialog id="infoModal" class="container">
        <span class="close-btn" id="closeInfoModal" data-id="infoModal">x</span>
        <h2 id="eventTitle"></h2>
        <p id="eventInfo"></p>
        <p id="eventTime"></p>
        <div id="mostrarEntrenos"></div>
    </dialog>

    <!-- Modal para crear un nuevo evento -->
    <dialog id="añadirModal" class="container" data-id="<?php echo count($_SESSION['gEntrenador']); ?>">
        <span class="close-btn" id="closeAñadir" data-id="añadirModal">x</span>
        <form id="añadirForm" >
            <h2>Crear Evento</h2>

            <div class="entreno" id="eventBloqueInput"></div>
            <div class="addBloque" id="eventAddBloqueInput" data-id="Input">Añadir bloque</div>


            <label for="eventTitleInput">Título</label>
            <div id="eventTitleInput-error" class="error-message"></div> 
            <input type="text" id="eventTitleInput" required>

            <label for="eventDescriptionInput">Descripción</label>
            <textarea id="eventDescriptionInput"></textarea>
            
            <label for="eventDateInput">Fecha</label>
            <div id="eventDateInput-error" class="error-message"></div> 
            <input type="date" id="eventDateInput" required>
            
            <label for="eventTimeInput">Hora inicio</label>
            <div id="eventTimeInput-error" class="error-message"></div> 
            <input type="time" id="eventTimeInput" required>
            
            <label for="eventTimeEndInput">Hora fin</label>
            <div id="eventTimeEndInput-error" class="error-message"></div> 
            <input type="time" id="eventTimeEndInput" required>
            
            <label for="eventSelectInput">Grupo</label>
            <select id="eventSelectInput" required>
                <?php
                
                foreach ($_SESSION['gEntrenador'] as $gid) {
                    $sql = "SELECT * FROM grupos WHERE id=$gid";
                    $res = $conn->query($sql);
                        while ($row = $res->fetch_assoc()) {
                        ?>
                            <option value="<?php echo $row['id']; ?> "><?php echo $row['nombre']; ?></option>;
                            <?php
                        }
                    }
                 ?>
            </select>
            <br>
            <button type="submit">Crear Evento</button>
        </form>
    </dialog>

        <!-- Modal para editar un evento -->
    <dialog id="editarModal" class="container">
        <span class="close-btn" id="closeEditar" data-id="editarModal">x</span>
        <form id="editarForm" >
            <h2>Editar Evento</h2>

            <div class="entreno" id="eventBloqueEdit"></div>
            <div class="addBloque" id="eventAddBloqueEdit" data-id="Edit">Añadir bloque</div>

            <label for="eventTitleEdit">Título</label>
            <div id="eventTitleEdit-error" class="error-message"></div> 
            <input type="text" id="eventTitleEdit" required>
            <br>
            <label for="eventDescriptionEdit">Descripción</label>
            <textarea id="eventDescriptionEdit"></textarea>
            <br>
            <label for="eventDateEdit">Fecha</label>
            <input type="date" id="eventDateEdit" required>
            <br>
            <label for="eventTimeEdit">Hora inicio</label>
            <div id="eventTimeEdit-error" class="error-message"></div> 
            <input type="time" id="eventTimeEdit" required>
            <br>
            <label for="eventTimeEndEdit">Hora fin</label>
            <div id="eventTimeEndEdit-error" class="error-message"></div> 
            <input type="time" id="eventTimeEndEdit" required>
            <br>
            <label for="eventSelectEdit">Grupo</label>
            <select id="eventSelectEdit" required>
                <?php
                
                foreach ($_SESSION['gEntrenador'] as $gid) {
                    $sql = "SELECT * FROM grupos WHERE id=$gid";
                    $res = $conn->query($sql);
                        while ($row = $res->fetch_assoc()) {
                        ?>
                            <option value="<?php echo $row['id']; ?> "><?php echo $row['nombre']; ?></option>;
                            <?php
                        }
                    }
                 ?>
            </select>
            <br>
            <div id="botones-modal">
                <button type="submit">Editar Evento</button>
                <button type="button" id="btnDelete" class="peligro">Borrar Evento</button>
            </div>
        </form>
    </dialog>


    <script src="../assets/js/auth_forms.js"></script>
    <script src="../assets/js/calendario.js"></script>

    <?php include_once('../templates/footer.html'); ?>
<?php
$conn->close();
?>