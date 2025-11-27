@extends('app')

@section('contenido')
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
<meta name="csrf-token" content="{{ csrf_token() }}">
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
        font-size: 2.2rem;
        color: #8ac3ff;
        margin-bottom: 20px;
    }

    .animate-charcter {
        text-transform: uppercase;
        background-image: linear-gradient(
            -225deg,
            #d1e9ff 0%,
            #a3d4ff 29%,
            #75bfff 67%,
            #4faafa 100%
        );
        background-size: auto auto;
        background-clip: border-box;
        background-size: 200% auto;
        color: #fff;
        background-clip: text;
        text-fill-color: transparent;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        animation: textclip 2s linear infinite;
        display: inline-block;
    }

    @keyframes textclip {
        to {
            background-position: 200% center;
        }
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
        /* font-size: 1.5rem; */
        color: #1bd647;
    }
    .winner-list {
        margin-top: 40px;
        font-size: 1.2rem;
        color: #ffffff;
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
        color: #1bd647;
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
        color: #1bd647;
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
        height: 70vh; /* Altura fija */
        width: 95%; /* Ocupa el ancho completo */
        background-color: #f8f9fa00; /* Color de fondo */
        padding: 10px; /* Espaciado interno */
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
        color: #333;
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

    .empleado-item.selected {
        background-color: blue;
        color: white;
    }

    .empleado-item.winner {
        background-color: green;
        color: white;
    }

    /* Contenedor del video */
    .video-container {
        position: fixed; /* Hace que el video esté en el fondo */
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: -1; /* Coloca el video detrás de los demás elementos */
        overflow: hidden;
    }

    /* Estilo para el video */
    #background-video {
        width: 100%;
        height: 100%;
        object-fit: cover; /* Asegura que el video cubra toda el área del contenedor */
    }

    /* Capa oscura sobre el video */
    .video-container::after {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5); /* Ajusta el valor del opacidad (0.5) para más o menos oscuridad */
        z-index: 1; /* Asegura que el filtro oscuro esté sobre el video, pero debajo del contenido */
    }

    /* Estilo del contenido */
    .content {
        position: relative;
        z-index: 2; /* Asegura que el contenido esté encima del video y la capa oscura */
        color: white; /* Para que el contenido sea legible sobre el fondo oscuro */
        padding: 20px;
    }

    /* Estilos del Modal sin fondo */
    .raffle-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }

    .raffle-modal-content {
        position: relative;
        background-color: transparent;
        padding: 20px;
        text-align: center;
        max-width: 1000px;
        width: 100%;
    }

    .raffle-countdown {
        font-size: 3em;
        font-weight: bold;
        color: white;
        margin-bottom: 20px;
    }

    .raffle-prizes {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
        gap: 10px;
        overflow-y: auto;
        max-height: 500px; /* Define la altura máxima del contenedor */
        padding: 10px;
    }

    .raffle-prizes span {
        background-color: #f1f1f1;
        border: 1px solid #ddd;
        border-radius: 5px;
        text-align: center;
        padding: 10px;
        transition: background-color 0.3s, color 0.3s;
    }

    .raffle-prizes span.selected {
        background-color: #007bff;
        color: #fff;
        font-weight: bold;
    }

    .close-modal-btn {
        position: absolute;
        top: -10px;
        right: -10px;
        font-size: 2em;
        color: white;
        background: transparent;
        border: none;
        cursor: pointer;
    }

    .close-modal-btn:hover {
        color: #dc3545; 
    }

    /* Animación de selección de premio */
    @keyframes selectPrizeAnimation {
        0% { opacity: 0.5; }
        25% { opacity: 1; }
        50% { opacity: 0.5; }
        75% { opacity: 1; }
        100% { opacity: 0.5; }
    }

    .rolling-text {
        animation: selectPrizeAnimation 0.5s infinite;
    }

    /* Personalización del scrollbar para navegadores compatibles */
    .raffle-prizes::-webkit-scrollbar {
        width: 8px; /* Ancho del scroll */
    }

    .raffle-prizes::-webkit-scrollbar-track {
        background: #f1f1f1; /* Color de fondo del track */
        border-radius: 10px; /* Bordes redondeados */
    }

    .raffle-prizes::-webkit-scrollbar-thumb {
        background: #007bff; /* Color del "pulgar" del scroll */
        border-radius: 10px; /* Bordes redondeados */
    }

    .raffle-prizes::-webkit-scrollbar-thumb:hover {
        background: #0056b3; /* Color más oscuro al pasar el mouse */
    }

    /* Para navegadores que no usan Webkit, mantener el diseño legible */
    .raffle-prizes {
        scrollbar-width: thin; /* Estilo general en Firefox */
        scrollbar-color: #007bff #f1f1f1; /* Color del pulgar y del fondo */
    }

    @keyframes blink {
        0%, 100% {
            opacity: 0;
        }
        50% {
            opacity: 1;
        }
    }

    .blink-text {
        animation: blink 1.7s infinite;
        color: #ffffff;
        font-weight: bold;
    }

    @keyframes slideIn {
        0% {
            transform: translateX(-100%);
            opacity: 0.2;
        }
        100% {
            transform: translateX(0);
            opacity: 1;
        }
    }

    .slide-text {
        animation: slideIn 1.5s ease-out;
        color: #8ac3ff;
        font-weight: bold;
    }

    .ganador-animado {
        position: relative;
        font-size: 6vh;
        color: #252839; /* Color negro inicial */
        text-transform: uppercase;
        font-weight: bold;
        overflow: hidden;
    }

    .ganador-animado::before {
        content: attr(data-text);
        position: absolute;
        top: 0;
        left: 0;
        width: 0; /* Comienza oculto */
        height: 100%;
        color: #01fe87; /* Color verde */
        white-space: nowrap;
        overflow: hidden;
        animation: revealText 3s forwards;
    }

    @keyframes revealText {
        0% {
            width: 0;
        }
        100% {
            width: 100%; /* Se revela todo el texto */
        }
    }

    .premio {
        display: block;
        margin-top: 10px;
        font-size: 3rem;
        color: #252839; /* Color inicial */
        font-weight: bold;
        opacity: 0; /* Comienza invisible */
        transform: translateY(-50px); /* Comienza un poco por encima */
        animation: premio 3s ease forwards;
        -webkit-text-stroke: 2px black; /* Contorno negro */
        text-stroke: 2px black; /* Soporte para otros navegadores */
    }

    @keyframes premio {
        0% {
            transform: translateY(-50px); /* Comienza moviéndose hacia arriba */
            opacity: 0;
            color: #252839; /* Color inicial oscuro */
        }
        30% {
            transform: translateY(10px); /* Rebote hacia abajo */
            opacity: 1;
            color: #01fe87; /* Color verde brillante */
        }
        60% {
            transform: translateY(-5px); /* Rebotando un poco hacia arriba */
            color: #ffb900; /* Cambio de color a un amarillo dorado */
        }
        100% {
            transform: translateY(0); /* Finaliza en su posición original */
            opacity: 1;
            color: #01fe87; /* Se queda con el color verde brillante */
        }
    }

    .waviy {
        position: relative;
        -webkit-box-reflect: below -20px linear-gradient(transparent, rgba(0, 0, 0, .2));
        font-size: 60px;
    }

    .waviy span {
        position: relative;
        color: #ffd700; /* Color dorado del texto */
        text-transform: uppercase;
        animation: waviy 1s infinite;
        animation-delay: calc(.1s * var(--i));
        -webkit-text-stroke: 2px black; /* Contorno negro */
        text-stroke: 2px black; /* Soporte para otros navegadores */
    }

    @keyframes waviy {
        0%, 40%, 100% {
            transform: translateY(0);
        }
        20% {
            transform: translateY(-20px); /* Subir las letras */
        }   
    }
</style>

    <div class="video-container">
        <video autoplay muted loop id="background-video">
            <source src={{ asset('background.mp4') }} type="video/mp4">
            Tu navegador no soporta el formato de video.
        </video>
    </div>

    <div class="content-section content">
        <h1 id="title" class="animate-charcter">Rifa Navideña Posada Fiscalia 2025</h1>
        <div class="button-container">
            <button id="raffleButton" class="btn btn-primary btn-lg btn-animated">
                <i class="bi bi-play-fill"></i>
            </button>
            <button id="stopButton" class="btn-stop d-none">
                Terminar
            </button>
        </div>
        <div id="roulette" class="d-none">
            <h2></h2>
        </div>
        <div class="empleados d-none" id="employee">
            @foreach ($empleados as $e)
                <div class="empleado-item" data-index="{{ $loop->index }}">
                    {{ $e->nombre }}
                </div>
            @endforeach
        </div>
        <div id="winner" class="d-none ">
            <p id="ganador" class="ganador-animado"></p>
        </div>
        <div id="winnerList" class="winner-list d-none" style="overflow-y: auto; ">
            <strong>Ganadores</strong>
        </div>
    </div>

    <div id="winnersDisplay" class="d-none">
        <h2 class="winners-title blink-text">🎉 ¡Los Ganadores de la Rifa! 🎉</h2>
        <div id="winnersList" class="winners-list"></div>
    </div>

    <div id="raffleModal" class="raffle-modal">
        <div class="raffle-modal-content">
            <div id='premioMayor' class="waviy d-none" style="display: flex; justify-content: center; margin-bottom: 10px">
                <span style="--i:1">¡</span>
                <span style="--i:2">P</span>
                <span style="--i:3">R</span>
                <span style="--i:4">E</span>
                <span style="--i:5">M</span>
                <span style="--i:6">I</span>
                <span style="--i:7">O</span>
                <span style="--i:8" class="mx-3"> </span>
                <span style="--i:9">M</span>
                <span style="--i:10">A</span>
                <span style="--i:11">Y</span>
                <span style="--i:12">O</span>
                <span style="--i:13">R</span>
                <span style="--i:14">!</span>
            </div>

            <div id="rafflePrizes" class="raffle-prizes d-none" 
                style="display: grid; 
                grid-template-columns: repeat(auto-fill, minmax(100px, 1fr)); 
                gap: 10px; overflow-y: auto; 
                max-height: 750px; 
                padding: 10px;"></div>
            <div id="countdown" class="raffle-countdown"></div>
            <div id="raffleWinner" class="raffle-countdown d-none">
                <span id="winnerText"></span>
                <span id="premio" class="premio"></span>
            </div>
            <button id="closeModalBtn" class="close-modal-btn">&times;</button>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.js"></script>
<!-- Cargar html2canvas desde CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>

<script>
    let empleados = @json($empleados);
    let premios = @json($premios);
    let premiosMayores = @json($premiosMayores);
    let winners = [];
    let currentWinnerIndex = 0;
    let play = false;
    let premioActual = '';
    let winnersShowed = false;

    const raffleButton = document.getElementById('raffleButton');
    const stopButton = document.getElementById('stopButton');
    const rouletteDiv = document.getElementById('roulette');
    const winnerDiv = document.getElementById('winner');
    const winnerPrize = document.getElementById('winnerPrize');
    const winnerList = document.getElementById('winnerList');
    const title = document.getElementById('title');
    const employee = document.getElementById('employee');
    const ganador = document.getElementById('ganador');
    const premioMayor = document.getElementById('premioMayor');

    const cssContSect = document.querySelectorAll('.content-section');
    const cssEmpl = document.querySelectorAll('.empleados');

    raffleButton.addEventListener('click', () => {
        rouletteDiv.classList.remove('d-none');
        employee.classList.remove('d-none');
        
        cssContSect.forEach(element => {
            element.style.marginTop = '20px';
        });

        if(play === true){
            cssEmpl.forEach(element => {
                element.style.height = '300px';
            });
            raffleButton.classList.add('d-none');
            stopButton.classList.add('d-none');
            winnerDiv.classList.add('d-none');
            startRoulette();
        }

        play = true;
    });

    // stopButton.addEventListener('click', () => {
    //     stopButton.classList.add('d-none');
    //     employee.classList.add('d-none')
    //     showWinners();
    //     setTimeout(()=>{
    //         guardarPagina();
    //     }, 2000);
    // });

    function startRoulette() {
        let interval = setInterval(() => {
            let randomIndex = Math.floor(Math.random() * empleados.length);
            let randomEmpleado = empleados[randomIndex];
            rouletteDiv.textContent = `${randomEmpleado.numero_emp} - ${randomEmpleado.nombre}`;
            
            // Resaltar el nombre en la lista y centrarlo
            highlightEmployeeInList(randomIndex);
        }, 100);

        setTimeout(() => {
            clearInterval(interval);
            selectWinner();
        }, 3000);
    }

    function highlightWinnerInList(index) {
        const employeeItems = document.querySelectorAll('.empleado-item');
        const selectedEmployee = employeeItems[index];
        
        // Marcar al ganador como verde
        selectedEmployee.classList.add('winner');  // Asegúrate de que la clase 'winner' esté definida en tu CSS
    }

    function highlightEmployeeInList(index) {
        const employeeItems = document.querySelectorAll('.empleado-item');
        const employeeContainer = document.getElementById('employee');

        // Quitar cualquier clase previamente agregada
        employeeItems.forEach(item => item.classList.remove('selected'));

        // Agregar la clase 'selected' al empleado actual
        const selectedEmployee = employeeItems[index];
        selectedEmployee.classList.add('selected');

        // Asegurarse de que el elemento sea visible en el contenedor
        const containerHeight = employeeContainer.offsetHeight;
        const employeeHeight = selectedEmployee.offsetHeight;
        const employeeOffset = selectedEmployee.offsetTop;

        employeeContainer.scrollTo({
            top: employeeOffset - (containerHeight / 2) + (employeeHeight / 2) - 125,
        });
    }

    function selectWinner() {
        let randomIndex;
        let randomEmpleado;

        do {
            randomIndex = Math.floor(Math.random() * empleados.length);
            randomEmpleado = empleados[randomIndex];
        } while (winners.some(winner => winner.numero_emp === randomEmpleado.numero_emp)); // Verifica si ya ha ganado

        // Marca al ganador en la lista
        markAsWinner(randomIndex);

        // Seleccion aleatoria de premio
        setTimeout(function() {
            iniciarRifa(premios);
        }, 4000);

        // Ejecutar hasta aqui, al terminar iniciarRifa continua con el codigo

        rouletteDiv.classList.add('d-none');
        winnerDiv.classList.remove('d-none');
        // winnerNumber.textContent = randomEmpleado.numero_emp;
        // winnerName.textContent = randomEmpleado.nombre;
        const concatenado = `${randomEmpleado.numero_emp} - ${randomEmpleado.nombre}`;
        ganador.textContent = concatenado;
        ganador.setAttribute('data-text', concatenado);
        setTimeout(function() {
            addWinnerToList(randomEmpleado);
                winners.push({
                numero_emp: empleados[randomIndex].numero_emp,
                nombre: empleados[randomIndex].nombre,
                area: empleados[randomIndex].area,
                n_premio: premioActual.numero_premio,
                premio: premioActual.premio
            });
        }, 17000);

        // Quitar la clase 'selected' de todos los empleados
        removeHighlightFromAllEmployees();

        // Mueve el scroll hasta el ganador
        scrollToWinner(randomIndex);
        
        currentWinnerIndex++;

        raffleButton.textContent = "Reanudar";
        raffleButton.classList.add('small-font');
        raffleButton.classList.add('btn-fix');
        raffleButton.classList.remove('btn');

        // stopButton.classList.remove('d-none');
        stopButton.classList.add('btn-stop-fix');

        winnerList.classList.remove('d-none');
        winnerDiv.classList.remove('d-none');
    }

    function iniciarRifa() {
        const modal = document.getElementById('raffleModal');
        const countdownElement = document.getElementById('countdown');
        const prizesContainer = document.getElementById('rafflePrizes');
        const closeModalBtn = document.getElementById('closeModalBtn');
        const winnerElement = document.getElementById('raffleWinner');

        countdownElement.classList.remove('d-none');
        prizesContainer.classList.add('d-none');
        winnerElement.classList.add('d-none');

        // Mostrar el modal
        modal.style.display = 'flex';

        // Iniciar la cuenta regresiva
        let countdown = 5;
        countdownElement.textContent = countdown;

        const countdownInterval = setInterval(() => {
            countdown--;
            countdownElement.textContent = countdown;

            if (countdown === 0) {
                countdownElement.classList.add('d-none');
                prizesContainer.classList.remove('d-none');
                clearInterval(countdownInterval);

                // Mostrar todos los premios
                if ((currentWinnerIndex % 4 === 0 && premiosMayores.length > 0) || premios.length === 0) {
                    premioMayor.classList.remove('d-none');
                    displayPrizes(premiosMayores);
                    startSelection(premiosMayores);
                } else if (premios.length > 0){
                    displayPrizes(premios);
                    startSelection(premios);
                }
            }
        }, 1000);

        // Cerrar el modal
        closeModalBtn.addEventListener('click', () => {
            modal.style.display = 'none';
            raffleButton.classList.remove('d-none');
            premioMayor.classList.add('d-none');

            if (premiosMayores.length === 0 && premios.length === 0 && !winnersShowed)  {
                stopButton.classList.add('d-none');
                employee.classList.add('d-none')
                showWinners();
            }
        });
    }

    function displayPrizes(prizes) {
        const prizesContainer = document.getElementById('rafflePrizes');
        prizesContainer.innerHTML = '';

        // Mostrar solo el numero_premio
        prizes.forEach(prize => {
            const prizeElement = document.createElement('span');
            prizeElement.textContent = prize.numero_premio; // Mostrar solo el número
            prizeElement.id = `prize-${prize.numero_premio}`;
            prizesContainer.appendChild(prizeElement);
        });
    }

    function startSelection(prizes) {
        const prizesContainer = document.getElementById('rafflePrizes');

        // Animación de selección aleatoria
        const interval = setInterval(() => {
            const randomPrizeIndex = Math.floor(Math.random() * prizes.length);
            const currentPrize = prizes[randomPrizeIndex];

            // Resaltar el premio actual
            highlightPrize(currentPrize);
        }, 100);

        setTimeout(() => {
            clearInterval(interval);
            const winnerPrize = getRandomPrize(prizes);
            premioActual = winnerPrize;
            highlightPrize(winnerPrize, true); // Marcar como ganador
            const winnerElement = document.getElementById('raffleWinner');
            const winnerText = document.getElementById('winnerText');
            const premio = document.getElementById('premio');

            // Mostrar el premio ganador (ahora mostramos el nombre del premio completo)
            winnerElement.classList.remove('d-none');
            winnerText.textContent = "¡El premio ganador es:";
            premio.textContent = winnerPrize.premio;

            if (winnerPrize.pdi === 1) {
                // Crear un nuevo elemento para el texto adicional
                const extraText = document.createElement('span');
                extraText.textContent = " - PDI"; // El texto que deseas añadir
                extraText.classList.add('blink-text'); // Agregar la clase al texto nuevo

                // Añadir el nuevo texto al elemento "premio"
                premio.appendChild(extraText);
            }
            winnerElement.style.display = 'block';

            // Eliminar el premio de la lista
            removePrize(winnerPrize, prizes);

        }, 5000); // Detener la animación después de 5 segundos
    }

    function highlightPrize(prize, isWinner = false) {
        const prizeElement = document.getElementById(`prize-${prize.numero_premio}`);
        const allPrizeElements = document.querySelectorAll('.raffle-prizes span');

        // Eliminar la clase de selección de todos los premios
        allPrizeElements.forEach(elem => elem.classList.remove('selected'));

        // Añadir la clase 'selected' al premio actual
        prizeElement.classList.add('selected');

        // Desplazar el contenedor para que el premio seleccionado sea visible
        prizeElement.scrollIntoView({
            block: 'center',
            inline: 'center'
        });

        // Si es el ganador, se marca con un color llamativo
        if (isWinner) {
            prizeElement.style.color = '#fff';
            prizeElement.style.fontWeight = 'bold';
        }
    }

    function getRandomPrize(list) {
        const randomIndex = Math.floor(Math.random() * list.length);
        return list[randomIndex];
    }

    function removePrize(prize, list) {
        const prizeIndex = list.indexOf(prize);
        if (prizeIndex > -1) {
            list.splice(prizeIndex, 1); // Eliminar el premio de la lista
        }
    }

    function markAsWinner(index) {
        const employeesDiv = document.querySelectorAll('.empleado-item');
        employeesDiv[index].classList.remove('selected');
        employeesDiv[index].classList.add('winner');
    }

    function addWinnerToList(winner) {
        const listItem = document.createElement('p');
        listItem.innerHTML = `<span>${winner.numero_emp}</span> - ${winner.nombre} - ${premioActual.numero_premio}`;
        winnerList.appendChild(listItem);
    }

    function showWinners() {
        winnersShowed = true;

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
                <div class="winner-name">${winner.numero_emp} - <strong>${winner.nombre}</strong> <br> ${winner.area}
                <br>
                <span>${winner.n_premio}</span> - <strong>${winner.premio}</strong>
                </div>
            `;
            
            winnersList.appendChild(winnerItem);

            // Enviar ganador al servidor
            fetch('/resultados', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'), // Token CSRF
                },
                body: JSON.stringify({
                    numero_emp: winner.numero_emp,
                    nombre: winner.nombre,
                    area: winner.area,
                    n_premio: winner.n_premio,
                    premio: winner.premio,
                }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log('Registro guardado:', data.data);
                } else {
                    console.error('Error al guardar el registro:', data);
                }
            })
            .catch(error => {
                console.error('Error en la solicitud:', error);
            });
        });

        // Espera a que termine la animación antes de ejecutar guardarPagina()
        winnersDisplay.addEventListener('animationend', function handleAnimationEnd(event) {
            if (event.animationName === "slideIn") { // Verifica si es la animación que esperas
                guardarPagina(); // Llama a la función
                winnersDisplay.removeEventListener('animationend', handleAnimationEnd); // Evita múltiples llamadas
            }
        });
    }

    // Nueva función para mover el scroll al ganador
    function scrollToWinner(index) {
        const employeeItems = document.querySelectorAll('.empleado-item');
        const employeeContainer = document.getElementById('employee');
        
        const selectedEmployee = employeeItems[index];
        
        // Desplazarse hasta el ganador
        const containerHeight = employeeContainer.offsetHeight;
        const employeeHeight = selectedEmployee.offsetHeight;
        const employeeOffset = selectedEmployee.offsetTop;

        // Desplazar el scroll para que el ganador quede centrado
        employeeContainer.scrollTo({
            top: employeeOffset - (containerHeight / 2) + (employeeHeight / 2) - 105,
        });
    }

    function removeHighlightFromAllEmployees() {
        const employeeItems = document.querySelectorAll('.empleado-item');
        employeeItems.forEach(item => {
            item.classList.remove('selected');  // Elimina la clase 'highlight' de todos
        });
    }

    function guardarPagina() {
        // Obtener todo el contenido del documento
        const contenidoHTML = document.documentElement.outerHTML;

        // Crear un blob con el contenido HTML
        const blob = new Blob([contenidoHTML], { type: 'text/html' });

        // Crear un enlace para descargar el archivo
        const link = document.createElement("a");
        link.href = URL.createObjectURL(blob);
        link.download = "GanadoresRifaFiscalia2024.html";

        // Simular un clic en el enlace para iniciar la descarga
        link.click();
    }
</script>
@endsection