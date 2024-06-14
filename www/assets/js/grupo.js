document.addEventListener('DOMContentLoaded', () => {
    const botonBorrar = document.getElementById('botonBorrar');
    const modalBorrar = document.getElementById('borrar');
    const cerrarModal = document.getElementById('cerrar');
    const confirmarBorrado = document.getElementById('confirmarBorrado');
    const botonBorrar2 = document.getElementById('borrar2');

    botonBorrar.addEventListener('click', (e) => {
        e.preventDefault();
        modalBorrar.showModal();
    });

    cerrarModal.addEventListener('click', (e) => {
        e.preventDefault();
        modalBorrar.close();
    });

    confirmarBorrado.addEventListener('change', function () {
        botonBorrar2.disabled = !confirmarBorrado.checked;
    });

});
