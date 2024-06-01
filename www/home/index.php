<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FullCalendar sin API de Google Calendar</title>
<script src="../lib/fullcalendar-6.1.13/dist/index.global.js"></script>
<script src="../lib/fullcalendar-6.1.13/packages/core/locales/es.global.js"></script>
<script src="../lib/fullcalendar-6.1.13/packages/google-calendar/index.global.js"></script>
<style>
        /* Estilos para el pop-up */
        #popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            padding: 20px;
            border: 1px solid #ccc;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }
    </style>

</head>
<body>
    <div id="calendario"></div>
    <div id="popup">
        <h2 id="eventTitle"></h2>
        <p id="eventInfo"></p>
    </div>
    <script src="calendario.js"></script>
</body>
</html>
