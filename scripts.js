function cargarCampañasVacunacion() {
    fetch('php/obtener_campañas.php')
        .then(res => res.json())
        .then(data => {
            const contenedor = document.getElementById('seccionVacunacion');
            const existente = document.getElementById('listaCampañas');
            if (existente) existente.remove();

            const lista = document.createElement('div');
            lista.id = 'listaCampañas';

            data.forEach(c => {
                const div = document.createElement('div');
                div.innerHTML = `
                    <h4>Campaña en ${c.colonia}</h4>
                    <p><strong>Fecha:</strong> ${c.fecha}</p>
                    <p><strong>Horario:</strong> ${c.horario}</p>
                    <p><strong>Ubicación:</strong> ${c.ubicacion}</p>
                    <p><strong>Vacunas disponibles:</strong> ${c.vacunas}</p>
                    <hr>
                `;
                lista.appendChild(div);
            });

            contenedor.appendChild(lista);
        });
}

function cargarAnimalesAdoptables() {
    fetch('php/obtener_adoptables.php')
        .then(res => res.json())
        .then(data => {
            const contenedor = document.getElementById('seccionAdoptables');
            const existente = document.getElementById('listaAdoptables');
            if (existente) existente.remove();

            const lista = document.createElement('div');
            lista.id = 'listaAdoptables';

            data.forEach(a => {
                const div = document.createElement('div');
                div.innerHTML = `
                    <h4>${a.nombre} (${a.especie})</h4>
                    <p><strong>Raza:</strong> ${a.raza}</p>
                    <p><strong>Edad:</strong> ${a.edad} años</p>
                    <p><strong>Descripción:</strong> ${a.descripcion}</p>
                    <img src="uploads/adoptables/${a.foto}" alt="${a.nombre}" width="200">
                    <hr>
                `;
                lista.appendChild(div);
            });

            contenedor.appendChild(lista);
        });
}

// Función que muestra el formulario correspondiente según la selección del usuario
function mostrarFormulario() {
    let opcion = document.getElementById('tipoAccion').value;  // Obtenemos el valor de la opción seleccionada
    document.querySelectorAll('.seccion').forEach(div => div.style.display = 'none'); // Ocultamos todas las secciones

    // Mostramos la sección correspondiente dependiendo de la opción seleccionada
    if (opcion === 'vacunacion') {
        document.getElementById('seccionVacunacion').style.display = 'block';
    } else if (opcion === 'adoptables') {
        document.getElementById('seccionAdoptables').style.display = 'block';
    } else if (opcion === 'denuncia') {
        document.getElementById('seccionDenuncia').style.display = 'block';
    } else if (opcion === 'extraviado') {
        document.getElementById('seccionExtraviado').style.display = 'block';
    }
}
