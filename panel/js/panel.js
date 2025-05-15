const sidebar = document.getElementById('sidebar');
const contenido = document.getElementById('contenido');
const btn = document.getElementById('sidebarToggle');

// Toggle Sidebar
btn.addEventListener('click', () => {
    sidebar.classList.toggle('active');
    contenido.classList.toggle('collapsed');
    btn.style.left = sidebar.classList.contains('active') ? sidebar.offsetWidth + 'px' : '0px';
    const icon = btn.querySelector('i');
    icon.classList.toggle('fa-chevron-left');
    icon.classList.toggle('fa-chevron-right');
});

// Posición inicial botón
window.onload = () => {
    btn.style.left = sidebar.classList.contains('active') ? sidebar.offsetWidth + 'px' : '0px';
};

// Modal abrir y cerrar
const cardCrear = document.querySelector('.card-crear');
const modal = document.getElementById('modalCrearProyecto');
const cerrarModalBtn = document.getElementById('cerrarModal');
const formularioCrear = document.getElementById('formularioCrearProyecto');

// Abrir Modal
cardCrear.addEventListener('click', () => {
    modal.style.display = 'flex';
});

// Cerrar Modal
cerrarModalBtn.addEventListener('click', () => {
    modal.style.display = 'none';
});

// Enviar formulario
formularioCrear.addEventListener('submit', (e) => {
    e.preventDefault();

    const datos = {
        nombre: document.getElementById('nombreProyecto').value,
        descripcion: document.getElementById('descripcionProyecto').value,
        fecha_inicio: document.getElementById('fechaInicio').value,
        fecha_fin: document.getElementById('fechaFin').value
    };

    // Aquí deberías hacer un fetch real a PHP
    console.log(datos);

    alert('Proyecto "' + datos.nombre + '" creado correctamente');
    modal.style.display = 'none';
});

// flatpickr("#fechaInicio", {
//     dateFormat: "d-m-Y"
// });

// flatpickr("#fechaFin", {
//     dateFormat: "d-m-Y"
// });

// Obtener todos los iconos
const iconCards = document.querySelectorAll('.icon-card');

// Agregar evento de clic a cada card
iconCards.forEach(card => {
    card.addEventListener('click', () => {
        // Eliminar la clase "selected" de todas las cards
        iconCards.forEach(c => c.classList.remove('selected'));

        // Agregar la clase "selected" a la card seleccionada
        card.classList.add('selected');

        // Obtener el icono seleccionado
        const selectedIcon = card.getAttribute('data-icon');

        // Asignar el icono al campo oculto
        document.getElementById('selectedIcon').value = selectedIcon;
    });
});



document.getElementById('formularioCrearProyecto').addEventListener('submit', function (event) {
    event.preventDefault();
    
    const formData = new FormData(this);
    
    // Log para ver los datos que se envían
    formData.forEach((value, key) => {
        console.log(key + ": " + value);
    });

    fetch('php/guardarProyecto.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        alert(data);  // Muestra la respuesta del PHP
    })
    .catch(error => console.error('Error:', error));
});
