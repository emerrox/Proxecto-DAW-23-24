const calendarioEl = document.getElementById('calendario');

const calendar = new FullCalendar.Calendar(calendarioEl, {

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
    eventClick: function(info) {
        info.jsEvent.preventDefault();
        event_info(info.event)
    },
    googleCalendarApiKey: 'AIzaSyDAghMbjkWasOZXvKGJKpEjw4m4rMZ2xv4',
    events: {
        googleCalendarId: '654e36d654a6538c60f36bfd84fd2e723220d816aa2bdf72baf5fb0b8cef15fe@group.calendar.google.com'
    }
});

function event_info(event) {
    let modal = document.getElementById('modal');
    let title = document.getElementById('eventTitle');
    let eventInfo = document.getElementById('eventInfo');
  
    title.textContent = event.title;
    eventInfo.textContent = `Fecha: ${event.start.toISOString()}
                            Descripción: ${event.extendedProps.descripcion}`;

    // Mostrar el modal
    modal.showModal();
    const close = document.getElementById('close');
    close.addEventListener('click',modal.click())
  }
  

calendar.render();

