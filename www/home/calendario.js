const $d = document,
        $calendarioEl = $d.getElementById('calendario'),
        $infoModal = $d.getElementById('infoModal'),
        $añadirModal = $d.getElementById('añadirModal'),
        $editarModal = $d.getElementById('editarModal'),
        $crearGrupo = $d.getElementById('crearGrupo'),
        $joinGrupo = $d.getElementById('joinGrupo'),
        $btnCerrar = $d.querySelectorAll('.close-btn'),
        $btnDelete = $d.getElementById('btnDelete'),
        $btnJoinGrupo = $d.getElementById('join_grupo'),
        $btnCrearGrupo = $d.getElementById('add_grupo');


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
        if (info.event.extendedProps.role == 'deportista') {
            mostrar_info(info.event);
        } else if (info.event.extendedProps.role == 'entrenador') {
            mostrar_editarForm(info.event);
        }
    },
    eventSources: [
        {
          url: './entrenos.php', 
          method: 'GET'
        }
      ],
      dateClick: function(info) {
          // Handle the case where no event is clicked
          mostrar_addForm(info.dateStr);
      }

});

function mostrar_info(e) {
    let title = $d.getElementById('eventTitle');
    let eventInfo = $d.getElementById('eventInfo');

    title.textContent = e.title;
    eventInfo.textContent = `Fecha: ${e.start.toISOString()}
                            Descripción: ${e.extendedProps.description}`;

    $infoModal.showModal();
}

function mostrar_addForm(dateStr) {
    if($añadirModal.dataset.id!=0){
        $d.getElementById('eventDateInput').value = dateStr;
        $añadirModal.showModal();
    }
}

function mostrar_editarForm(entreno) {
    $d.getElementById('editarForm').dataset.id=entreno.id
    $d.getElementById('eventTitleEdit').value = entreno.title
    $d.getElementById('eventDescriptionEdit').value = entreno.extendedProps.description
    $d.getElementById('eventDateEdit').value = entreno.start.toISOString().split('T')[0]
    $d.getElementById('eventTimeEdit').value = entreno.start.toISOString().split('T')[1].slice(0, 5)
    $d.getElementById('eventTimeEndEdit').value = entreno.end.toISOString().split('T')[1].slice(0, 5)
    $editarModal.showModal();
}

$d.addEventListener('DOMContentLoaded', ()=>{
    calendar.render();
    $btnCerrar.forEach(btn => {
        btn.addEventListener('click', function() {
            const modalId = btn.getAttribute('data-id');
            const modal = $d.getElementById(modalId);
            //console.log(modalId);
            if (modalId == 'añadirModal') {
                modal.querySelector('form').reset();
            }
            modal.close();
    
        });
    });
    calendar.refetchEvents()
})

$añadirModal.addEventListener('submit', function(e) {
    e.preventDefault();
    let title = $d.getElementById('eventTitleInput').value;
    let description = $d.getElementById('eventDescriptionInput').value;
    let date = $d.getElementById('eventDateInput').value;
    let startTime = $d.getElementById('eventTimeInput').value;
    let endTime = $d.getElementById('eventTimeEndInput').value;
    let grupoId = $d.getElementById('eventSelectInput').value;
    console.log(grupoId);

    const newEntreno = {
        title: title,
        description: description,
        start: `${date}T${startTime}:00`,
        end: `${date}T${endTime}:00`,
        grupoId: grupoId
    };

    fetch('./entrenos.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(newEntreno)
    })

    
    .then(response => response.json())
    .then(data => {
        if (data.status == 'success') {
            calendar.refetchEvents(); 
            $añadirModal.close();
        } else {
            console.log(data.message);
        }
    });
});

$editarModal.addEventListener('submit', function(e) {
    e.preventDefault();
    let id = $d.getElementById('editarForm').dataset.id
    let title = $d.getElementById('eventTitleEdit').value;
    let description = $d.getElementById('eventDescriptionEdit').value;
    let date = $d.getElementById('eventDateEdit').value;
    let startTime = $d.getElementById('eventTimeEdit').value;
    let endTime = $d.getElementById('eventTimeEndEdit').value;
    let grupoId = $d.getElementById('eventSelectEdit').value;

    const updatedEntreno = {
        title: title,
        description: description,
        start: `${date}T${startTime}:00`,
        end: `${date}T${endTime}:00`,
        grupoId: grupoId
    };

    fetch(`./entrenos.php?id=${id}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(updatedEntreno)
    })

    
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            let event = calendar.getEventById(id);
            event.setProp('title', title);
            event.setExtendedProp('description', description);
            event.setStart(`${date}T${startTime}:00`);
            event.setEnd(`${date}T${endTime}:00`);
            $editarModal.close();
        } else {
            console.log(data.message);
        }
    });
});

$btnDelete.addEventListener('click', ()=>{
    const id = editarForm.dataset.id;

    fetch(`./entrenos.php?id=${id}`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            // Elimina el evento del calendario
            const event = calendar.getEventById(id);
            event.remove();

            // Cierra el modal
            $d.getElementById('editarForm').dataset.id = ''
            $editarModal.close();
        } else {
            console.log(data.message);
        }
    });
});

$btnCrearGrupo.addEventListener('click',(e)=>{
    e.preventDefault()
    $crearGrupo.showModal();
})

$btnJoinGrupo.addEventListener('click',(e)=>{
    e.preventDefault()
    $joinGrupo.showModal();
})