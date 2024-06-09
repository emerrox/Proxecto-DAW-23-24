const $d = document,
        boton_borrar = $d.getElementById('botonBorrar'),
        modal_borrar = $d.getElementById('borrar');

boton_borrar.addEventListener('click', (e)=>{
    e.preventDefault();
    modal_borrar.showModal();
});



const confirmarBorrado = document.getElementById('confirmarBorrado');
const botonBorrar2 = document.getElementById('borrar2');

// Cerrar modal al hacer clic en el botón de cancelar
modal_borrar.querySelector('.cerrar').addEventListener('click', function () {
    modal_borrar.close();
});

// Habilitar/deshabilitar botón de borrar según el estado del checkbox
confirmarBorrado.addEventListener('change', function () {
    botonBorrar2.disabled = !confirmarBorrado.checked;
});