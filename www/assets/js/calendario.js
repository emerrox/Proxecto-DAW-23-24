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
      $btnCrearGrupo = $d.getElementById('add_grupo'),
      $addBloque = $d.querySelectorAll('.addBloque');

let calendar = new FullCalendar.Calendar($calendarioEl, {
    locale: 'es',
    firstDay: 1,
    initialView: 'dayGridWeek',
    headerToolbar: {
        left: 'prev,today,next',
        center: 'title',
        right: 'dayGridWeek,dayGridMonth,listMonth'
    },
    buttonText: {
        today: 'Hoy',
        month: 'Mes',
        day: 'Día',
        list: 'Lista'
    },
    eventClick: function(info) {
        if (info.event.extendedProps.role == 'deportista') {
            mostrar_info(info.event);
        } else if (info.event.extendedProps.role == 'entrenador') {
            mostrar_editarForm(info.event);
        }
    },
    eventSources: [{
        url: './entrenos.php',
        method: 'GET'
    }],
    dateClick: function(info) {
        mostrar_addForm(info.dateStr);
    }
});

function mostrar_info(e) {
    let title = $d.getElementById('eventTitle');
    let eventInfo = $d.getElementById('eventInfo');
    let eventTime = $d.getElementById('eventTime');
    let mostrarEntrenos = $d.getElementById('mostrarEntrenos');
    
    title.textContent = e.title;
    eventTime.textContent = `${e.start.toISOString().split('T')[1].split(':')[0]}:${e.start.toISOString().split('T')[1].split(':')[1]} - ${e.end.toISOString().split('T')[1].split(':')[0]}:${e.end.toISOString().split('T')[1].split(':')[1]} `;
    eventInfo.textContent = e.extendedProps.description;
    const arrEntrenos = JSON.parse(e.extendedProps.bloques);
    mostrarEntrenos.innerHTML = '';  
    arrEntrenos.forEach((innerArray, index) => {
        let bloque = $d.createElement('div');
        bloque.className = 'bloque';
        innerArray.forEach(element => {
            let serie = $d.createElement('div');
            serie.className = 'serie';
            
            let duracion = $d.createElement('p');
            let medida = $d.createElement('p');
            let ritmo = $d.createElement('p');
            
            duracion.textContent = element.duracion;
            medida.textContent = element.tipo;
            console.log(element);
            ritmo.textContent = element.ritmo;

            serie.appendChild(duracion);
            serie.appendChild(medida);
            serie.appendChild(ritmo);
            bloque.appendChild(serie);
        });
        mostrarEntrenos.appendChild(bloque);
    });
    $infoModal.showModal();
}

function mostrar_addForm(dateStr) {
    if ($añadirModal.dataset.id != 0) {
        $d.getElementById('eventDateInput').value = dateStr;
        $añadirModal.showModal();
    }
}

$addBloque.forEach(btn => {
    btn.addEventListener('click', () => {
        const contenedorEntrenos = $d.querySelector(`#eventBloque${btn.dataset.id}`);
        const nuevoDiv = document.createElement('div');
        nuevoDiv.className = 'bloque';

        // Contenedor para botones de añadir y eliminar
        const contenedorBotonesBloque = document.createElement('div');
        contenedorBotonesBloque.className = 'contenedor-botones-bloque';

        // Botón de eliminación del bloque
        const btnEliminarBloque = document.createElement('button');
        btnEliminarBloque.className = 'eliminar-bloque';
        btnEliminarBloque.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z"/></svg>';
        btnEliminarBloque.addEventListener('click', () => {
            contenedorEntrenos.removeChild(nuevoDiv);
        });

        // Botón de añadir serie
        const divSerie = document.createElement('div');
        divSerie.className = 'añadir-serie';
        divSerie.textContent = 'Añadir Serie';

        divSerie.addEventListener('click', () => {
            const nuevaSerie = document.createElement('div');
            nuevaSerie.className = 'serie';

            const selectRitmo = document.createElement('select');
            selectRitmo.className = 'ritmo';
            const opcionesRitmo = ['r0', 'r1', 'r2', 'r3', 'r4', 'r5'];
            opcionesRitmo.forEach(opcion => {
                const optionRitmo = document.createElement('option');
                optionRitmo.value = opcion;
                optionRitmo.textContent = opcion;
                selectRitmo.appendChild(optionRitmo);
            });

            const selectTipo = document.createElement('select');
            selectTipo.className = 'tipo';
            const optionMetros = document.createElement('option');
            optionMetros.value = 'metros';
            optionMetros.textContent = 'Metros';
            const optionKm = document.createElement('option');
            optionKm.value = 'km';
            optionKm.textContent = 'Kilómetros';
            const optionMinutos = document.createElement('option');
            optionMinutos.value = 'minutos';
            optionMinutos.textContent = 'Minutos';
            const optionSegundos = document.createElement('option');
            optionSegundos.value = 'segundos';
            optionSegundos.textContent = 'Segundos';
            selectTipo.appendChild(optionMetros);
            selectTipo.appendChild(optionKm);
            selectTipo.appendChild(optionMinutos);
            selectTipo.appendChild(optionSegundos);

            const inputDuracion = document.createElement('input');
            inputDuracion.className = 'duracion';
            inputDuracion.type = 'number';
            inputDuracion.placeholder = 'Duración';

            // Botón de eliminación de la serie
            const btnEliminarSerie = document.createElement('button');
            btnEliminarSerie.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z"/></svg>';
            btnEliminarSerie.className = 'eliminar-serie';
            btnEliminarSerie.addEventListener('click', () => {
                nuevoDiv.removeChild(nuevaSerie);
            });

            nuevaSerie.appendChild(selectRitmo);
            nuevaSerie.appendChild(selectTipo);
            nuevaSerie.appendChild(inputDuracion);
            nuevaSerie.appendChild(btnEliminarSerie);

            nuevoDiv.appendChild(nuevaSerie);
        });

        contenedorBotonesBloque.appendChild(divSerie);
        contenedorBotonesBloque.appendChild(btnEliminarBloque);
        nuevoDiv.appendChild(contenedorBotonesBloque);
        contenedorEntrenos.appendChild(nuevoDiv);
    });
});



function mostrar_editarForm(entreno) {
    $d.getElementById('editarForm').dataset.id = entreno.id;
    $d.getElementById('eventTitleEdit').value = entreno.title;
    $d.getElementById('eventDescriptionEdit').value = entreno.extendedProps.description;
    $d.getElementById('eventDateEdit').value = entreno.start.toISOString().split('T')[0];
    $d.getElementById('eventTimeEdit').value = entreno.start.toISOString().split('T')[1].slice(0, 5);
    $d.getElementById('eventTimeEndEdit').value = entreno.end.toISOString().split('T')[1].slice(0, 5);

    const arrEntrenos = JSON.parse(entreno.extendedProps.bloques);
    const eventBloqueEdit = $d.getElementById('eventBloqueEdit');
    eventBloqueEdit.innerHTML = '';  

    arrEntrenos.forEach((innerArray, index) => {
        let bloque = $d.createElement('div');
        bloque.className = 'bloque';

        innerArray.forEach(serieData => {
            const nuevaSerie = document.createElement('div');
            nuevaSerie.className = 'serie';

            const selectRitmo = document.createElement('select');
            selectRitmo.className = 'ritmo';
            const opcionesRitmo = ['r0', 'r1', 'r2', 'r3', 'r4', 'r5'];
            opcionesRitmo.forEach(opcion => {
                const optionRitmo = document.createElement('option');
                optionRitmo.value = opcion;
                optionRitmo.textContent = opcion;
                selectRitmo.appendChild(optionRitmo);
            });
            selectRitmo.value = serieData.ritmo;

            const selectTipo = document.createElement('select');
            selectTipo.className = 'tipo';
            const optionMetros = document.createElement('option');
            optionMetros.value = 'metros';
            optionMetros.textContent = 'Metros';
            const optionKm = document.createElement('option');
            optionKm.value = 'km';
            optionKm.textContent = 'Kilómetros';
            const optionMinutos = document.createElement('option');
            optionMinutos.value = 'minutos';
            optionMinutos.textContent = 'Minutos';
            const optionSegundos = document.createElement('option');
            optionSegundos.value = 'segundos';
            optionSegundos.textContent = 'Segundos';
            selectTipo.appendChild(optionMetros);
            selectTipo.appendChild(optionKm);
            selectTipo.appendChild(optionMinutos);
            selectTipo.appendChild(optionSegundos);
            selectTipo.value = serieData.tipo;

            const inputDuracion = document.createElement('input');
            inputDuracion.className = 'duracion';
            inputDuracion.type = 'number';
            inputDuracion.placeholder = 'Duración';
            inputDuracion.value = serieData.duracion;

            // Botón de eliminación de la serie
            const btnEliminarSerie = document.createElement('button');
            btnEliminarSerie.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z"/></svg>';
            btnEliminarSerie.className = 'eliminar-serie';
            btnEliminarSerie.addEventListener('click', () => {
                bloque.removeChild(nuevaSerie);
            });

            nuevaSerie.appendChild(selectRitmo);
            nuevaSerie.appendChild(selectTipo);
            nuevaSerie.appendChild(inputDuracion);
            nuevaSerie.appendChild(btnEliminarSerie);

            bloque.appendChild(nuevaSerie);
        });

        // Contenedor para botones de añadir y eliminar
        const contenedorBotonesBloque = document.createElement('div');
        contenedorBotonesBloque.className = 'contenedor-botones-bloque';

        // Botón de añadir serie
        const divSerie = document.createElement('div');
        divSerie.className = 'añadir-serie';
        divSerie.textContent = 'Añadir Serie';

        // Añadir evento para añadir una nueva serie
        divSerie.addEventListener('click', () => {
            const nuevaSerie = document.createElement('div');
            nuevaSerie.className = 'serie';

            const selectRitmo = document.createElement('select');
            selectRitmo.className = 'ritmo';
            const opcionesRitmo = ['r0', 'r1', 'r2', 'r3', 'r4', 'r5'];
            opcionesRitmo.forEach(opcion => {
                const optionRitmo = document.createElement('option');
                optionRitmo.value = opcion;
                optionRitmo.textContent = opcion;
                selectRitmo.appendChild(optionRitmo);
            });

            const selectTipo = document.createElement('select');
            selectTipo.className = 'tipo';
            const optionMetros = document.createElement('option');
            optionMetros.value = 'metros';
            optionMetros.textContent = 'Metros';
            const optionKm = document.createElement('option');
            optionKm.value = 'km';
            optionKm.textContent = 'Kilómetros';
            const optionMinutos = document.createElement('option');
            optionMinutos.value = 'minutos';
            optionMinutos.textContent = 'Minutos';
            const optionSegundos = document.createElement('option');
            optionSegundos.value = 'segundos';
            optionSegundos.textContent = 'Segundos';
            selectTipo.appendChild(optionMetros);
            selectTipo.appendChild(optionKm);
            selectTipo.appendChild(optionMinutos);
            selectTipo.appendChild(optionSegundos);

            const inputDuracion = document.createElement('input');
            inputDuracion.className = 'duracion';
            inputDuracion.type = 'number';
            inputDuracion.placeholder = 'Duración';

            // Botón de eliminación de la serie
            const btnEliminarSerie = document.createElement('button');
            btnEliminarSerie.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z"/></svg>';
            btnEliminarSerie.className = 'eliminar-serie';
            btnEliminarSerie.addEventListener('click', () => {
                bloque.removeChild(nuevaSerie);
            });

            nuevaSerie.appendChild(selectRitmo);
            nuevaSerie.appendChild(selectTipo);
            nuevaSerie.appendChild(inputDuracion);
            nuevaSerie.appendChild(btnEliminarSerie);

            bloque.appendChild(nuevaSerie);
        });

        // Botón de eliminación del bloque
        const btnEliminarBloque = document.createElement('button');
        btnEliminarBloque.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z"/></svg>';
        btnEliminarBloque.className = 'eliminar-bloque';
        btnEliminarBloque.addEventListener('click', () => {
            eventBloqueEdit.removeChild(bloque);
        });

        contenedorBotonesBloque.appendChild(divSerie);
        contenedorBotonesBloque.appendChild(btnEliminarBloque);
        bloque.appendChild(contenedorBotonesBloque);
        eventBloqueEdit.appendChild(bloque);
    });

    $editarModal.showModal();
}






function getBloques(form) {
    const bloques = form.querySelectorAll('.bloque');
    let resultado = [];

    bloques.forEach(bloque => {
        let bloqueDatos = [];
        const entrenos = bloque.querySelectorAll('.serie');

        entrenos.forEach(entreno => {
            const select1 = entreno.querySelector('.ritmo').value;
            const select2 = entreno.querySelector('.tipo').value;
            const input1 = entreno.querySelector('.duracion').value;

            const datosEntreno = {
                ritmo: select1,
                tipo: select2,
                duracion: input1
            };

            bloqueDatos.push(datosEntreno);
        });

        resultado.push(bloqueDatos);
    });

    return JSON.stringify(resultado);
}

$d.addEventListener('DOMContentLoaded', () => {
    calendar.render();
    $btnCerrar.forEach(btn => {
        btn.addEventListener('click', function() {
            const modalId = btn.getAttribute('data-id');
            const modal = $d.getElementById(modalId);
            if (modalId == 'añadirModal') {
                modal.querySelector('form').reset();
                modal.querySelector('.entreno').innerHTML = '';
            }
            modal.close();
        });
    });
    calendar.refetchEvents();
});

$añadirModal.addEventListener('submit', function(e) {
    e.preventDefault();
    let inputs = $añadirModal.querySelectorAll('input[type="text"], input[type="password"], input[type="email"], input[type="time"]');
    if (validarForm(inputs)) {
        let title = $d.getElementById('eventTitleInput').value;
        let description = $d.getElementById('eventDescriptionInput').value;
        let date = $d.getElementById('eventDateInput').value;
        let startTime = $d.getElementById('eventTimeInput').value;
        let endTime = $d.getElementById('eventTimeEndInput').value;
        let grupoId = $d.getElementById('eventSelectInput').value;

        let bloques = getBloques($añadirModal);
        const newEntreno = {
            title: title,
            description: description,
            start: `${date}T${startTime}:00`,
            end: `${date}T${endTime}:00`,
            grupoId: grupoId,
            bloques: bloques
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
    } else {
        e.preventDefault();
    }
});

$editarModal.addEventListener('submit', function(e) {
    e.preventDefault();
    let inputs = $editarModal.querySelectorAll('input[type="text"], input[type="password"], input[type="email"], input[type="time"]');
    if (validarForm(inputs)) {
        let id = $d.getElementById('editarForm').dataset.id;
        let title = $d.getElementById('eventTitleEdit').value;
        let description = $d.getElementById('eventDescriptionEdit').value;
        let date = $d.getElementById('eventDateEdit').value;
        let startTime = $d.getElementById('eventTimeEdit').value;
        let endTime = $d.getElementById('eventTimeEndEdit').value;
        let grupoId = $d.getElementById('eventSelectEdit').value;

        let bloques = getBloques($editarModal);
        const updatedEntreno = {
            title: title,
            description: description,
            start: `${date}T${startTime}:00`,
            end: `${date}T${endTime}:00`,
            grupoId: grupoId,
            bloques: bloques
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
                event.setExtendedProp('bloques', bloques);
                event.setStart(`${date}T${startTime}:00`);
                event.setEnd(`${date}T${endTime}:00`);
                $editarModal.close();
            } else {
                console.log(data.message);
            }
        });
    }
});

$btnDelete.addEventListener('click', () => {
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
            const event = calendar.getEventById(id);
            event.remove();

            $d.getElementById('editarForm').dataset.id = '';
            $editarModal.close();
        } else {
            console.log(data.message);
        }
    });
});

$btnCrearGrupo.addEventListener('click', (e) => {
    e.preventDefault();
    $crearGrupo.showModal();
});

$btnJoinGrupo.addEventListener('click', (e) => {
    e.preventDefault();
    $joinGrupo.showModal();
});
