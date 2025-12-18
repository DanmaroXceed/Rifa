document.addEventListener('DOMContentLoaded', function () {
    const initialScreen = document.getElementById('initial-screen');
    const premiosScreen = document.getElementById('premios-screen');
    const ruletaScreen = document.getElementById('ruleta-screen');
    const finRifaScreen = document.getElementById('fin-rifa-screen');
    const premiosContainer = document.getElementById('premios-container');
    const startBtn = document.getElementById('start-btn');
    const nombreAnimacion = document.getElementById('nombre-animacion');
    const ganadorFinal = document.getElementById('ganador-final-container');
    const ganadorNombre = document.getElementById('ganador-nombre');
    const ganadorArea = document.getElementById('ganador-area');
    const ganadorPremio = document.getElementById('ganador-premio');
    const premioActivoNombre = document.getElementById('premio-activo-nombre');
    const btnContinuar = document.getElementById('btn-continuar');
    const btnNuevaRifa = document.getElementById('btn-nueva-rifa');
    const ganadoresScreen = document.getElementById('ganadores-screen');
    const listaGanadores = document.getElementById('lista-ganadores');
    const btnVerGanadores = document.getElementById('btn-ver-ganadores');
    const btnVolverInicio = document.getElementById('btn-volver-inicio');

    // Instancia del modal de Bootstrap
    const modalGanadores = new bootstrap.Modal(document.getElementById('modalGanadores'));
    const btnFlotante = document.getElementById('btn-flotante-ganadores');
    const listaGanadoresModal = document.getElementById('lista-ganadores-modal');

    let premioSeleccionado = null;
    let empleadosDisponibles = [];
    let animacionActiva = false;

    // Iniciar
    if (startBtn) {
        startBtn.addEventListener('click', cargarPremios);
    }

    async function cargarPremios() {
        initialScreen.classList.add('hidden');
        try {
            const res = await fetch('/premios-disponibles');
            const premios = await res.json();
            if (premios.length === 0) {
                mostrarFinRifa();
                return;
            }
            premiosScreen.classList.remove('hidden');
            premiosContainer.innerHTML = premios.map(p => {
                let cls = 'premio-card';
                if (p.pm) cls += ' pm';
                else if (p.pdi) cls += ' pdi';
                return `<div class="${cls}" 
                    data-id="${p.id}" 
                    data-nombre="${p.premio}" 
                    data-num="${p.numero_premio}">
                    #${p.numero_premio}<br>${p.premio}
                </div>`;
            }).join('');
        } catch (e) {
            alert('Error al cargar premios.');
        }
    }

    premiosContainer?.addEventListener('click', async (e) => {
        const card = e.target.closest('.premio-card');
        if (!card || animacionActiva) return;

        premioSeleccionado = {
            id: card.dataset.id,
            nombre: card.dataset.nombre,
            numero: card.dataset.num
        };

        premioActivoNombre.textContent = `Premio: #${premioSeleccionado.numero} - ${premioSeleccionado.nombre}`;

        try {
            const res = await fetch('/empleados-disponibles');
            empleadosDisponibles = await res.json();
            if (empleadosDisponibles.length === 0) {
                alert('No hay empleados disponibles para este premio.');
                return;
            }
        } catch (e) {
            alert('Error al cargar empleados.');
            return;
        }

        premiosScreen.classList.add('hidden');
        ruletaScreen.classList.remove('hidden');
        ganadorFinal.classList.add('hidden');
        nombreAnimacion.textContent = 'Preparando...';
        setTimeout(iniciarRuleta, 500);
    });

    function iniciarRuleta() {
        if (animacionActiva) return;
        animacionActiva = true;

        // 1. Determinar el ganador ANTES de la animación.
        const total = empleadosDisponibles.length;
        const ganador = empleadosDisponibles[Math.floor(Math.random() * total)];

        const duracion = 5000;
        const inicio = Date.now();

        // 2. Iniciar el intervalo de animación.
        const intervalo = setInterval(() => {
            const transcurrido = Date.now() - inicio;

            if (transcurrido >= duracion) {
                // 4. Detener la animación.
                clearInterval(intervalo);

                // 5. Asegurarse de que el nombre del ganador real se muestre.
                nombreAnimacion.textContent = ganador.nombre;

                // 6. Finalizar el sorteo después de un breve retraso para que el usuario vea el resultado.
                setTimeout(() => finalizarSorteo(ganador), 500);
                return;
            }

            // 3. Mostrar un nombre aleatorio durante la animación.
            const random = empleadosDisponibles[Math.floor(Math.random() * total)];
            nombreAnimacion.textContent = random.nombre;
        }, 100);
    }

    async function finalizarSorteo(ganador) {
        // Registrar en BD
        try {
            const res = await fetch('/registrar-ganador', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': window.csrfToken
                },
                body: JSON.stringify({
                    numero_emp: ganador.numero_emp,
                    nombre: ganador.nombre,
                    area: ganador.area,
                    n_premio: premioSeleccionado.numero,
                    premio: premioSeleccionado.nombre
                })
            });

            if (!res.ok) throw new Error('Error al guardar');
        } catch (e) {
            console.error(e);
            alert('Error al registrar ganador.');
            animacionActiva = false;
            return;
        }

        // Mostrar ganador
        ganadorNombre.textContent = ganador.nombre;
        ganadorArea.textContent = `Área: ${ganador.area}`;
        ganadorPremio.textContent = `Premio: ${premioSeleccionado.nombre}`;
        ganadorFinal.classList.remove('hidden');
        animacionActiva = false;
    }

    // Continuar a siguiente premio
    btnContinuar?.addEventListener('click', () => {
        ruletaScreen.classList.add('hidden');
        ganadorFinal.classList.add('hidden');
        cargarPremios(); // vuelve a cargar premios restantes
    });

    // Fin de rifa
    function mostrarFinRifa() {
        initialScreen.classList.add('hidden');
        premiosScreen.classList.add('hidden');
        ruletaScreen.classList.add('hidden');
        finRifaScreen.classList.remove('hidden');
    }

    // Nueva rifa (limpia todo)
    btnNuevaRifa?.addEventListener('click', () => {
        if (confirm('¿Reiniciar toda la rifa? Esto borrará todos los ganadores.')) {
            // Opcional: agregar endpoint para limpiar tabla `ganadors`
            location.reload();
        }
    });

    // Ver ganadores
    btnVerGanadores?.addEventListener('click', async () => {
        try {
            const res = await fetch('/ganadores');
            const ganadores = await res.json();

            const container = document.getElementById('lista-ganadores');
            if (!container) return;

            if (ganadores.length === 0) {
                container.innerHTML = '<p class="text-center" style="color: #8ac9ff; margin-top: 20px;">Aún no hay ganadores registrados.</p>';
            } else {
                container.innerHTML = ganadores.map(g => {
                    const esExtra = g.n_premio === 'EXTRA';
                    const premioTexto = esExtra 
                        ? `<span style="color:#ff7373;">${g.premio} (Extraoficial)</span>`
                        : `${g.premio} (#${g.n_premio})`;

                    return `
                    <div class="ganador-item">
                        <div class="nombre">${g.nombre}</div>
                        <div class="detalle">
                            <strong>Premio:</strong> ${premioTexto}
                        </div>
                        <div class="detalle">
                            <strong>Área:</strong> ${g.area}
                        </div>
                    </div>
                    `;
                }).join('');
            }

            finRifaScreen.classList.add('hidden');
            ganadoresScreen.classList.remove('hidden');
        } catch (e) {
            alert('Error al cargar los ganadores.');
            console.error(e);
        }
    });

    // Volver al inicio
    btnVolverInicio?.addEventListener('click', () => {
        ganadoresScreen.classList.add('hidden');
        initialScreen.classList.remove('hidden');
    });

    // Evento: abrir modal y cargar ganadores
    btnFlotante?.addEventListener('click', async function () {
        try {
            const response = await fetch('/ganadores');
            const ganadores = await response.json();

            if (ganadores.length === 0) {
                listaGanadoresModal.innerHTML = '<p class="text-center">Aún no hay ganadores.</p>';
            } else {
                listaGanadoresModal.innerHTML = ganadores.map(g => `
                    <div class="ganador-item">
                        <div class="nombre">${g.nombre}</div>
                        <div class="detalle">Área: ${g.area}</div>
                        <div class="detalle">Premio: ${g.premio} (#${g.n_premio})</div>
                    </div>
                `).join('');
            }

            // Mostrar el modal
            modalGanadores.show();
        } catch (error) {
            console.error('Error al cargar los ganadores:', error);
            listaGanadoresModal.innerHTML = '<p class="text-center text-danger">Error al cargar los ganadores.</p>';
        }
    });

    // -------------------

    // Instancia del modal
    const modalSorteoEspecial = new bootstrap.Modal(document.getElementById('modalSorteoEspecial'));

    // Abrir modal al hacer clic en el botón flotante
    document.getElementById('btn-flotante-extraoficial')?.addEventListener('click', () => {
        modalSorteoEspecial.show();
    });

    // --- Lógica del Sorteo Especial ---
    const modalSorteoEspecialEl = document.getElementById('modalSorteoEspecial');
    const btnIniciarSorteoEspecial = document.getElementById('btn-iniciar-sorteo-especial');
    const sorteoEspecialInicio = document.getElementById('sorteo-especial-inicio');
    const sorteoEspecialRuleta = document.getElementById('sorteo-especial-ruleta');
    const nombreAnimacionEspecial = document.getElementById('nombre-animacion-especial');
    const sorteoEspecialGanador = document.getElementById('sorteo-especial-ganador');
    const ganadorNombreEspecial = document.getElementById('ganador-nombre-especial');
    const ganadorAreaEspecial = document.getElementById('ganador-area-especial');

    let animacionEspecialActiva = false;

    btnIniciarSorteoEspecial?.addEventListener('click', iniciarSorteoEspecial);

    async function iniciarSorteoEspecial() {
        if (animacionEspecialActiva) return;
        animacionEspecialActiva = true;

        sorteoEspecialInicio.classList.add('hidden');
        sorteoEspecialGanador.classList.add('hidden');
        sorteoEspecialRuleta.classList.remove('hidden');
        nombreAnimacionEspecial.textContent = 'Buscando...';

        let empleadosParaSorteo = [];
        try {
            const res = await fetch('/empleados-disponibles');
            empleadosParaSorteo = await res.json();
            if (empleadosParaSorteo.length === 0) {
                nombreAnimacionEspecial.textContent = 'No hay nadie';
                animacionEspecialActiva = false;
                return;
            }
        } catch (e) {
            nombreAnimacionEspecial.textContent = 'Error';
            animacionEspecialActiva = false;
            return;
        }

        const duracion = 5000;
        const inicio = Date.now();
        const total = empleadosParaSorteo.length;

        const intervaloEspecial = setInterval(() => {
            const transcurrido = Date.now() - inicio;
            if (transcurrido >= duracion) {
                clearInterval(intervaloEspecial);
                finalizarSorteoEspecial(); // Backend decide el ganador
                return;
            }
            const random = empleadosParaSorteo[Math.floor(Math.random() * total)];
            nombreAnimacionEspecial.textContent = random.nombre;
        }, 100);
    }

    async function finalizarSorteoEspecial() {
        let response;
        try {
            response = await fetch('/sorteo-extraoficial', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': window.csrfToken
                },
                body: JSON.stringify({
                    premio: 'Premio Especial'
                })
            });

            const data = await response.json();

            if (!response.ok || !data.success) {
                throw new Error(data.error || 'Error desconocido del servidor.');
            }
            
            const ganador = data.ganador;
            ganadorNombreEspecial.textContent = ganador.nombre;
            ganadorAreaEspecial.textContent = `Área: ${ganador.area}`;
        
            sorteoEspecialRuleta.classList.add('hidden');
            sorteoEspecialGanador.classList.remove('hidden');

        } catch (e) {
            console.error(e);
            nombreAnimacionEspecial.textContent = e.message || 'Error al sortear.';
            // Revertir a la pantalla de inicio del modal tras un error
            setTimeout(() => {
                sorteoEspecialRuleta.classList.add('hidden');
                sorteoEspecialInicio.classList.remove('hidden');
            }, 2000);
        } finally {
            animacionEspecialActiva = false;
        }
    }

    // Resetear el modal de sorteo especial cuando se cierra
    modalSorteoEspecialEl?.addEventListener('hidden.bs.modal', () => {
        sorteoEspecialGanador.classList.add('hidden');
        sorteoEspecialRuleta.classList.add('hidden');
        sorteoEspecialInicio.classList.remove('hidden');
        nombreAnimacionEspecial.textContent = 'Preparando...';
        animacionEspecialActiva = false;
    });
});