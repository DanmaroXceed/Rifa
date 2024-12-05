@extends('app')

@section('contenido')
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
<style>
    body {
        background-color: #f7f9fc;
        color: #333;
        font-family: 'Poppins', sans-serif;
        justify-content: center;
        align-items: center;
        text-align: center;
        margin: 0;
    }

    .content-section {
        margin-top: 40vh;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    h1 {
        font-size: 2.5rem;
        color: #007bff;
        margin-bottom: 20px;
    }

    .btn-animated {
        animation: pulse 2s infinite;
    }
    @keyframes pulse {
        0%, 100% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.1);
        }
    }
    .winner {
        font-size: 1.5rem;
        margin-top: 20px;
        color: #28a745;
    }
    .winner-list {
        margin-top: 40px;
        font-size: 1.2rem;
        color: #555;
    }
    #roulette h2 {
        font-size: 2rem;
        color: #ff9900;
    }

    .button-container {
        display: flex;
        flex-direction: column; /* Los botones se apilan verticalmente */
        align-items: center; /* Centra horizontalmente */
        justify-content: center; /* Centra verticalmente */
    }

    .btn {
        width: 120px;
        height: 120px;
        font-size: 2.5rem;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 0;
        background-color: #28a745;
        border: none;
        color: white;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        transition: background-color 0.3s;
    }

    .btn-fix{
        position: fixed;
        bottom: 30px;
        left: 30px;
        width: 120px;
        height: 120px;
        font-size: 2.5rem;
        border-radius: 50%;
        justify-content: center;
        align-items: center;
        padding: 0;
        background-color: #28a745;
        border: none;
        color: white;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        transition: background-color 0.3s;
    }

    .btn:hover {
        background-color: #218838;
    }

    .small-font {
        font-size: 1.2rem; /* Reduce el tamaño de la fuente */
    }

    #winnersDisplay {
        background-color: #28a745;
        color: white;
        border-radius: 10px;
        padding: 30px;
        margin: 20px auto; /* Centra horizontalmente */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        animation: fadeIn 1s ease-out;
        width: 95%;
        max-width: 80%; /* Limita el ancho máximo */
        position: relative; /* Necesario si usas vertical centering */
        top: 50%; /* Mueve hacia abajo */
    }

    .winners-title {
        font-size: 2rem;
        text-align: center;
        margin-bottom: 20px;
    }

    .winners-list {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .winner-item {
        font-size: 1.5rem;
        margin: 10px 0;
        padding: 10px;
        background-color: #fff;
        color: #28a745;
        border-radius: 5px;
        width: 80%;
        animation: slideIn 0.5s ease-out;
        text-align: center;
    }

    .winner-label {
        font-size: 1.2rem;
        font-weight: bold;
        color: #f39c12; /* Color llamativo para el label */
        margin-bottom: 5px;
    }

    .winner-name {
        font-size: 1.4rem;
        color: #28a745;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    @keyframes slideIn {
        from {
            transform: translateY(30px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }
    
    .btn-stop {
        color: #dc3545; /* Color de texto */
        background-color: transparent;
        border: 2px solid #dc3545; /* Borde rojo */
        padding: 0.5rem 1rem; /* Tamaño del botón */
        font-size: 1rem; /* Tamaño de fuente */
        border-radius: 0.25rem; /* Bordes redondeados */
        transition: all 0.3s ease-in-out;
        margin-top: 1rem; /* Espacio entre los botones */
    }

    .btn-stop-fix{
        position: fixed;
        bottom: 30px;
        right: 30px;
    }

    .btn-stop:hover {
        color: #fff; /* Texto blanco al pasar el ratón */
        background-color: #dc3545; /* Fondo rojo al pasar el ratón */
        border-color: #dc3545; /* Asegura el color del borde */
    }

    .empleados {
        margin: 20px;
        height: 300px; /* Altura fija */
        width: 95%; /* Ocupa el ancho completo */
        background-color: #f8f9fa; /* Color de fondo */
        padding: 10px; /* Espaciado interno */
        border: 1px solid #dee2e6; /* Borde para un recuadro */
        border-radius: 5px; /* Bordes redondeados */
        overflow-y: auto; /* Desplazamiento vertical si es necesario */
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Sombra para destacar */
        display: grid; /* Activar grid */
        grid-template-columns: repeat(4, 1fr); /* 4 columnas de igual ancho */
        gap: 10px; /* Espaciado entre los elementos */
        align-items: start; /* Alinear contenido al inicio */
    }

    .empleado-item {
        background-color: #fff; /* Fondo blanco */
        border: 1px solid #dee2e6; /* Borde alrededor */
        border-radius: 5px; /* Bordes redondeados */
        padding: 10px; /* Espaciado interno */
        text-align: center; /* Centrar texto */
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Sombra */
    }

    /* Personalización del scrollbar para navegadores compatibles */
    .empleados::-webkit-scrollbar {
        width: 8px; /* Ancho del scroll */
    }

    .empleados::-webkit-scrollbar-track {
        background: #f1f1f1; /* Color de fondo del track */
        border-radius: 10px; /* Bordes redondeados */
    }

    .empleados::-webkit-scrollbar-thumb {
        background: #007bff; /* Color del "pulgar" del scroll */
        border-radius: 10px; /* Bordes redondeados */
    }

    .empleados::-webkit-scrollbar-thumb:hover {
        background: #0056b3; /* Color más oscuro al pasar el mouse */
    }

    /* Para navegadores que no usan Webkit, mantener el diseño legible */
    .empleados {
        scrollbar-width: thin; /* Estilo general en Firefox */
        scrollbar-color: #007bff #f1f1f1; /* Color del pulgar y del fondo */
    }
</style>

    <div class="content-section">
        <h1 id="title">Rifa Navideña 2024</h1>
        <div class="button-container">
            <button id="raffleButton" class="btn btn-primary btn-lg btn-animated">
                <i class="bi bi-play-fill"></i>
            </button>
            <button id="stopButton" class="btn-stop d-none">
                Terminar
            </button>
        </div>
        <div id="roulette" class="d-none">
            <h2>🎡 Girando...</h2>
        </div>
        <div class="empleados d-none" id="employee">
            @foreach ($empleados as $e)
                <div class="empleado-item">
                    {{ $e->nombre }}
                </div>
            @endforeach
        </div>
        <div id="winner" class="winner d-none">
            <p><span id="winnerNumber"></span> - <span id="winnerName"></span></p>
            <p id="winnerLabel"></p>
        </div>
        <div id="winnerList" class="winner-list d-none">
            <strong>Ganadores</strong>
        </div>
    </div>

    <div id="winnersDisplay" class="d-none">
        <h2 class="winners-title">🎉 ¡Los Ganadores de la Rifa! 🎉</h2>
        <div id="winnersList" class="winners-list"></div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.js"></script>

<script>
    let empleados = @json($empleados);
    let winners = [];
    let currentWinnerIndex = 0;

    const raffleButton = document.getElementById('raffleButton');
    const stopButton = document.getElementById('stopButton');
    const rouletteDiv = document.getElementById('roulette');
    const winnerDiv = document.getElementById('winner');
    const winnerNumber = document.getElementById('winnerNumber');
    const winnerName = document.getElementById('winnerName');
    const winnerList = document.getElementById('winnerList');
    const title = document.getElementById('title');
    const employee = document.getElementById('employee');

    const elements = document.querySelectorAll('.content-section');

    raffleButton.addEventListener('click', () => {
        rouletteDiv.classList.remove('d-none');
        employee.classList.remove('d-none');
        raffleButton.classList.add('d-none');
        stopButton.classList.add('d-none');
        winnerDiv.classList.add('d-none');

        elements.forEach(element => {
            element.style.marginTop = '20px';
        });
        startRoulette();
    });

    stopButton.addEventListener('click', () => {
        stopButton.classList.add('d-none');
        employee.classList.add('d-none')
        showWinners();
    })

    function startRoulette() {
        let interval = setInterval(() => {
            let randomIndex = Math.floor(Math.random() * empleados.length);
            let randomEmpleado = empleados[randomIndex];
            rouletteDiv.textContent = `🎡 ${randomEmpleado.numero_emp} - ${randomEmpleado.nombre}`;
        }, 100);

        setTimeout(() => {
            clearInterval(interval);
            selectWinner();
        }, 3000);
    }

    function selectWinner() {
        let randomIndex;
        let randomEmpleado;

        do {
            randomIndex = Math.floor(Math.random() * empleados.length);
            randomEmpleado = empleados[randomIndex];
        } while (winners.includes(randomEmpleado.numero_emp));

        winners.push({
            numero_emp: empleados[randomIndex].numero_emp,  // Asigna el número de empleado correctamente
            nombre: empleados[randomIndex].nombre,          // Asigna el nombre del empleado correctamente
            // label: labels[currentWinnerIndex]                       // Asigna la etiqueta del ganador (Tercer, Segundo, Primer)
        });
        rouletteDiv.classList.add('d-none');
        winnerDiv.classList.remove('d-none');
        winnerNumber.textContent = randomEmpleado.numero_emp;
        winnerName.textContent = randomEmpleado.nombre;
        // winnerLabel.textContent = labels[currentWinnerIndex];
        addWinnerToList(randomEmpleado);

        // Elimina al ganador de la lista de empleados
        empleados.splice(randomIndex, 1);

        currentWinnerIndex++;

        raffleButton.textContent = "Reanudar";
        raffleButton.classList.add('small-font');
        raffleButton.classList.add('btn-fix');
        raffleButton.classList.remove('d-none');
        raffleButton.classList.remove('btn');

        stopButton.classList.remove('d-none');
        stopButton.classList.add('btn-stop-fix');

        winnerList.classList.remove('d-none');
        winnerDiv.classList.remove('d-none');
    }

    function addWinnerToList(winner) {
        const listItem = document.createElement('p');
        listItem.innerHTML = `<span>${winner.numero_emp}</span> - ${winner.nombre}`;
        winnerList.appendChild(listItem);
    }

    function showWinners() {
    // Oculta el botón y la ruleta
        raffleButton.classList.add('d-none');
        rouletteDiv.classList.add('d-none');
        winnerDiv.classList.add('d-none');
        winnerList.classList.add('d-none');
        title.classList.add('d-none');

        // Muestra la lista de ganadores
        const winnersDisplay = document.getElementById('winnersDisplay');
        winnersDisplay.classList.remove('d-none');

        // Limpia el contenido de la lista de ganadores
        const winnersList = document.getElementById('winnersList');
        winnersList.innerHTML = ''; // Limpia la lista

        // Añade a los ganadores a la lista
        winners.forEach((winner) => {
            const winnerItem = document.createElement('div');
            winnerItem.classList.add('winner-item');
            
            // Muestra el label arriba del nombre
            winnerItem.innerHTML = `
                <div class="winner-name">${winner.numero_emp} - ${winner.nombre}</div>
            `;
            
            winnersList.appendChild(winnerItem);
        });
    }

</script>
@endsection