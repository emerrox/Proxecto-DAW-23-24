const $d = document,
        $calendarioEl = document.getElementById('calendario')

let entrenos = []

const calendar = new FullCalendar.Calendar($calendarioEl, {

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
    eventClick: mostrar_info(),
    events: entrenos
    // googleCalendarApiKey: 'AIzaSyDAghMbjkWasOZXvKGJKpEjw4m4rMZ2xv4',
    // events: {
    //     googleCalendarId: '654e36d654a6538c60f36bfd84fd2e723220d816aa2bdf72baf5fb0b8cef15fe@group.calendar.google.com'
    // }
});

function mostrar_info(e) {
    let modal = document.getElementById('modal');
    let title = document.getElementById('eventTitle');
    let eventInfo = document.getElementById('eventInfo');
  
    title.textContent = e.title;
    eventInfo.textContent = `Fecha: ${e.start.toISOString()}
                            Descripción: ${e.extendedProps.descripcion}`;

    // Mostrar el modal
    modal.showModal();
    const close = document.getElementById('close');
    close.addEventListener('click', ()=>modal.close())
  }
  
function getEventos() {

}
async function getEntrenos(url) {
    fetch(url)
    .then(response => response.json())
    .then(data => {
      console.log(data);
    })
    .catch(error => {
      console.error(error);
    });
  }
document.addEventListener('DOMContentLoaded',()=>{
    /* *** 

        CAMBIAR URL ANTES DE ENTREGAR!!!

    *** */
    entrenos = getEntrenos('http://localhost/Proxecto-DAW-23-24/www/home/entrenos.php')
    console.log(entrenos);
    // calendar.render();

})

