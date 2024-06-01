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
        showPopup(info);
    },
    googleCalendarApiKey: 'AIzaSyDAghMbjkWasOZXvKGJKpEjw4m4rMZ2xv4',
    events: {
        googleCalendarId: '654e36d654a6538c60f36bfd84fd2e723220d816aa2bdf72baf5fb0b8cef15fe@group.calendar.google.com'
    }
});

function showPopup(info) {
    const popup = document.getElementById('popup');
    const title = document.getElementById('eventTitle');
    const info = document.getElementById('eventInfo');
  
    // Llena el pop-up con la información del evento
    title.textContent = info.event.title;
    info.textContent = `Fecha: ${info.event.start.toISOString()}
                        Descripción: ${info.event.extendedProps.descripcion}`;
  
    // Muestra el pop-up
    popup.style.display = "block";
  
    // Centra el pop-up en la pantalla
    popup.style.left = (window.innerWidth - popup.offsetWidth) / 2 + "px";
    popup.style.top = (window.innerHeight - popup.offsetHeight) / 2 + "px";
  }
  

calendar.render();

