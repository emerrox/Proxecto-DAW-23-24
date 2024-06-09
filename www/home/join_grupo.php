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

</head>
<body>
    <p><a href="../auth/logout.php">cerrar sesion</a></p>
    <h2 class="encabezado">Entrenos</h2>    
    <div id="calendario"></div>

    <h2 class="encabezado">Grupos</h2>
    <div id="grupos">
    <ul id="grupos-lista">
            <?php
            // Añadir filas por grupos del que es entrenador
            foreach ($_SESSION['gEntrenador'] as $gid) {
                $grupo = get_grupo($gid); // Obtener la información del grupo mediante la función
            
                if ($grupo) { // Verificar si se obtuvo información del grupo
                    $nombre = $grupo['nombre'];
                    $descripcion = $grupo['descripcion'];
                    $grupoId = $gid;
            
                    echo "<li>";
                    echo "<a href='grupo.php?gid=$grupoId'>";
                    echo "<div><strong>Nombre:</strong> $nombre</div>";
                    echo "<div><strong>Descripción:</strong> $descripcion</div>";
                    echo "<div><strong>Rol:</strong> Entrenador</div>";
                    echo "<div><strong>Entrenadores:</strong>";
            
                    $entrenadores = get_entrenadores_grupo($grupoId); // Obtener la lista de entrenadores
            
                    foreach ($entrenadores as $entrenador) {
                        echo " " . $entrenador['nombre'];
                    }
            
                    echo "</div>";
                    echo "</a>";
                    echo "</li>";
                }
            }

            // Añadir filas por grupos del que es deportista
            foreach ($_SESSION['gDeportista'] as $gid) {
                $grupo = get_grupo($gid); // Obtener la información del grupo mediante la función
            
                if ($grupo) { // Verificar si se obtuvo información del grupo
                    $nombre = $grupo['nombre'];
                    $descripcion = $grupo['descripcion'];
                    $grupoId = $gid;
            
                    echo "<li>";
                    echo "<a href='grupo.php?gid=$grupoId'>";
                    echo "<div><strong>Nombre:</strong> $nombre</div>";
                    echo "<div><strong>Descripción:</strong> $descripcion</div>";
                    echo "<div><strong>Rol:</strong> Deportista</div>";
                    echo "<div><strong>Entrenadores:</strong>";
            
                    $entrenadores = get_entrenadores_grupo($grupoId); // Obtener la lista de entrenadores
            
                    foreach ($entrenadores as $entrenador) {
                        echo " " . $entrenador['nombre'];
                    }
            
                    echo "</div>";
                    echo "</a>";
                    echo "</li>";
                }
            }
            ?>
        </ul>
    </div>
            
    <button id="add_grupo">Crear grupo</button>

    <button id="join_grupo">Unirse a grupo</button>

    <!-- Modal para mostrar formulario de unirse a grupo -->
    <dialog id="joinGrupo">
    <span class="close-btn" id="closejoinGrupo" data-id="joinGrupo">x</span>
        <form id="joinGrupoForm" method="POST" action="join_grupo.php">
            <h2>Unirse a nuevo grupo</h2>
            
            <label for="id">Código del grupo:</label>
            <input type="text" id="idJoinGrupo" name="id" required><br><br>

            <button type="submit">Unirse</button>
        </form>
    </dialog>

    <!-- Modal para mostrar formulario de crear grupo -->
    <dialog id="crearGrupo">
    <span class="close-btn" id="closeCrearGrupo" data-id="crearGrupo">x</span>
        <form id="crearGrupoForm" method="POST" action="nuevo_grupo.php">
            <h2>Crear Nuevo Grupo</h2>
            
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombreCrearGrupo" name="nombre" required><br><br>

            <label for="descripcion">Descripción:</label>
            <textarea id="descripcionCrearGrupo" name="descripcion" required></textarea><br><br>

            <button type="submit">Crear Grupo</button>
        </form>
    </dialog>

    <!-- Modal para mostrar la información del evento -->
    <dialog id="infoModal">
        <span class="close-btn" id="closeInfoModal" data-id="infoModal">x</span>
        <h2 id="eventTitle"></h2>
        <p id="eventInfo"></p>
    </dialog>

    <!-- Modal para crear un nuevo evento -->
    <dialog id="añadirModal" data-id="<?php echo count($_SESSION['gEntrenador']); ?>">
        <span class="close-btn" id="closeAñadir" data-id="añadirModal">x</span>
        <form id="añadirForm" >
            <h2>Crear Evento</h2>
            <label for="eventTitleInput">Título</label>
            <input type="text" id="eventTitleInput" required>
            <br>
            <label for="eventDescriptionInput">Descripción</label>
            <textarea id="eventDescriptionInput"></textarea>
            <br>
            <label for="eventDateInput">Fecha</label>
            <input type="date" id="eventDateInput" required>
            <br>
            <label for="eventTimeInput">Hora inicio</label>
            <input type="time" id="eventTimeInput" required>
            <br>
            <label for="eventTimeEndInput">Hora fin</label>
            <input type="time" id="eventTimeEndInput" required>
            <br>
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
    <dialog id="editarModal">
        <span class="close-btn" id="closeEditar" data-id="editarModal">x</span>
        <form id="editarForm" >
            <h2>Editar Evento</h2>
            <label for="eventTitleEdit">Título</label>
            <input type="text" id="eventTitleEdit" required>
            <br>
            <label for="eventDescriptionEdit">Descripción</label>
            <textarea id="eventDescriptionEdit"></textarea>
            <br>
            <label for="eventDateEdit">Fecha</label>
            <input type="date" id="eventDateEdit" required>
            <br>
            <label for="eventTimeEdit">Hora inicio</label>
            <input type="time" id="eventTimeEdit" required>
            <br>
            <label for="eventTimeEndEdit">Hora fin</label>
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
            <button type="submit">Editar Evento</button>
            <button type="button" id="btnDelete">Borrar Evento</button>
        </form>
    </dialog>

    <script src="calendario.js"></script>
</body>
</html>
<?php
$conn->close();
?>