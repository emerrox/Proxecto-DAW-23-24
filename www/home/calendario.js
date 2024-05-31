const calendarioEl = document.getElementById('calendario');

const eventos = [
    {
        id: 1,
        title: "Evento 1",
        start: "2024-05-29T10:00:00",
        end: "2024-05-29T12:00:00"
    },
    {
        id: 2,
        title: "Evento 2",
        start: "2024-05-30T14:00:00",
        end: "2024-05-30T16:00:00"
    },
    {
        id: 3,
        title: "Evento 3",
        start: "2024-06-03T09:00:00",
        allDay: true
    }
];

const calendar = new Calendar(calendarioEl, {
    //events: eventos,
    plugins: [ googleCalendarPlugin ],
    locale: 'es',
    firstDay: 1,
    headerToolbar: {
        left : 'prev,today,next',
        center : 'title',
        right : 'dayGridMonth, timeGridWeek, listMonth'
    },
    buttonText: {
        today: 'Hoy',
        month: 'Mes',
        week: 'Semana',
        day: 'Día',
        list: 'Lista'
    },
    dateClick: function(info) {
        alert('Fecha: ' + info.dateStr);
    },
    googleCalendarApiKey: 'AIzaSyDAghMbjkWasOZXvKGJKpEjw4m4rMZ2xv4', // Reemplaza con tu API Key
    events: {
        googleCalendarId: '654e36d654a6538c60f36bfd84fd2e723220d816aa2bdf72baf5fb0b8cef15fe' // Reemplaza con tu ID de Google Calendar
    }
});

calendar.render();
