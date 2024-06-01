<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FullCalendar sin API de Google Calendar</title>
<script src="../lib/fullcalendar-6.1.13/dist/index.global.js"></script>
<script src="../lib/fullcalendar-6.1.13/packages/core/locales/es.global.js"></script>
<script src="../lib/fullcalendar-6.1.13/packages/google-calendar/index.global.js"></script>

</head>
<body>
    <div id="calendario"></div>
    <dialog id="modal">
        <span id="close" style="float: right; cursor: pointer;">&times;</span>
        <h2 id="eventTitle"></h2>
        <p id="eventInfo"></p>
    </dialog>
    <script src="calendario.js"></script>
</body>
</html>
