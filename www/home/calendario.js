const $d = document,
        $calendarioEl = $d.getElementById('calendario')


let calendar = new FullCalendar.Calendar($calendarioEl, {

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
    eventClick: function(info){
        mostrar_info(info.event);
    },
    eventSources: [
        {
        /**** 
        *
        *   CAMBIAR URL ANTES DE ENTREGAR!!!
        *
        ****/
          url: 'http://localhost/Proxecto-DAW-23-24/www/home/entrenos.php', // Replace with your actual endpoint URL
          method: 'GET', // Default method is GET, you can change it if needed
          failureTolerance: 0 // Set to 0 to always trigger an error on failure
        }
      ]

});

function mostrar_info(e) {
    let modal = $d.getElementById('modal');
    let title = $d.getElementById('eventTitle');
    let eventInfo = $d.getElementById('eventInfo');
  
    title.textContent = e.title;
    eventInfo.textContent = `Fecha: ${e.start.toISOString()}
                            Descripción: ${e.extendedProps.description}`;

    // Mostrar el modal
    modal.showModal();
    const close = $d.getElementById('close');
    close.addEventListener('click', ()=>modal.close())
  }
  


$d.addEventListener('DOMContentLoaded', ()=>{

    calendar.render();

})

