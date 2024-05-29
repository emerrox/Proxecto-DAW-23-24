const { Calendar, EventApi } = FullCalendar;

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
    events: eventos,
    locale: 'es'
});

calendar.render();
