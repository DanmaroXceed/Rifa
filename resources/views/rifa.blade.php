@extends('app')

@section('contenido')
<link href="{{ asset('css/rifa.css') }}" rel="stylesheet">

<div class="video-container">
    <video autoplay muted loop id="background-video">
        <source src="{{ asset('background.mp4') }}" type="video/mp4">
        Tu navegador no soporta el formato de video.
    </video>
</div>

<div class="content-overlay" id="initial-screen">
    <h1 id="title" class="animate-character">Rifa Navideña Posada Fiscalía 2025</h1>
    <button id="start-btn" class="btn-start">Iniciar Rifa</button>
</div>

<div class="content-overlay hidden" id="premios-screen">
    <h2 class="section-title">Selecciona un premio para rifar</h2>
    <div id="premios-container" class="premios-grid"></div>
</div>

<div class="content-overlay hidden" id="ruleta-screen">
    <div class="premio-activo-header">
        <h3 id="premio-activo-nombre" class="premio-activo-title">Premio: Cargando...</h3>
    </div>
    <div class="ruleta-container">
        <div id="nombre-animacion" class="nombre-animacion">Preparando...</div>
    </div>
    <div id="ganador-final-container" class="ganador-final hidden">
        <h2>🎉 ¡Ganador!</h2>
        <p class="ganador-nombre" id="ganador-nombre"></p>
        <p class="ganador-area" id="ganador-area"></p>
        <p class="ganador-premio" id="ganador-premio"></p>
        <button id="btn-continuar" class="btn-start">Continuar</button>
    </div>
</div>

<div class="content-overlay hidden" id="fin-rifa-screen">
    <h2>🎁 ¡Rifa finalizada!</h2>
    <p>Todos los premios han sido asignados.</p>
    <button id="btn-ver-ganadores" class="btn-start">Ver Ganadores</button>
</div>

<!-- Pantalla de ganadores -->
<div class="content-overlay hidden" id="ganadores-screen">
    <h2 class="section-title">🏆 Ganadores de la Rifa 2025</h2>
    <div id="lista-ganadores" class="ganadores-grid">
        <!-- Se llenará con JS -->
    </div>
    <button id="btn-volver-inicio" class="btn-start">Volver al Inicio</button>
</div>

<!-- Botón flotante: Ver Ganadores -->
<button id="btn-flotante-ganadores" class="btn-flotante-ganadores"style="bottom: 20px;">
    👑
</button>
<!-- Botón flotante 2: sorteo especial. -->
<button id="btn-flotante-extraoficial" class="btn-flotante-ganadores" style="bottom: 84px;" data-bs-toggle="modal" data-bs-target="#modalSorteoEspecial">
    ⚙️
</button>

<!-- Modal de Ganadores (Bootstrap 5) -->
<div class="modal fade" id="modalGanadores" tabindex="-1" aria-labelledby="modalGanadoresLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-md">
    <div class="modal-content" style="background: #0b1a2d; color: white; border: 1px solid #1e3a5f;">
      <div class="modal-header" style="background: #0d253f; border-bottom: 1px solid #1e3a5f; padding: 1rem 1.25rem;">
        <h5 class="modal-title" id="modalGanadoresLabel" style="color: #FFD700; font-weight: 700; letter-spacing: 0.5px;">
          🏆 Ganadores
        </h5>
        <button type="button" class="btn-close" 
                data-bs-dismiss="modal" 
                aria-label="Cerrar"
                style="color: white; opacity: 0.8; margin-top: -4px;">
        </button>
      </div>
      <div class="modal-body text-white" id="lista-ganadores-modal" style="padding: 1.25rem;">
        <p class="text-center text-muted">Cargando...</p>
      </div>
    </div>
  </div>
</div>

<!-- Modal: Sorteo Especial -->
<div class="modal fade" id="modalSorteoEspecial" tabindex="-1" aria-labelledby="modalSorteoEspecialLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-md">
    <div class="modal-content" style="background: #0b1a2d; color: white; border: 1px solid #1e3a5f;">
      <div class="modal-header" style="background: #0d253f; border-bottom: 1px solid #1e3a5f; padding: 1rem 1.25rem;">
        <h3 id="modalSorteoEspecialLabel" class="modal-title" style="color: #FFD700; font-weight: 700; letter-spacing: 0.5px;">
          Sorteo Especial
        </h3>
        <button type="button" class="btn-close" 
                data-bs-dismiss="modal" 
                aria-label="Cerrar"
                style="color: white; opacity: 0.8; margin-top: -4px;">
        </button>
      </div>
      <div class="modal-body text-center" style="padding: 1.25rem;">
        <!-- Vista inicial del modal -->
        <div id="sorteo-especial-inicio">
            <p class="mb-4 opacity-80" style="color: white;">Se rifará un premio especial entre los participantes restantes.</p>
            <button id="btn-iniciar-sorteo-especial" class="btn btn-warning btn-lg px-5 fw-bold" style="background-color: #FFD700; border-color: #FFD700; color: #0b1a2d;">
              Iniciar
            </button>
        </div>

        <!-- Vista de la ruleta -->
        <div id="sorteo-especial-ruleta" class="hidden">
            <div class="ruleta-container">
                <div id="nombre-animacion-especial" class="nombre-animacion" style="font-size: 2rem; min-height: 80px;">Preparando...</div>
            </div>
        </div>

        <!-- Vista del ganador -->
        <div id="sorteo-especial-ganador" class="hidden" style="padding: 20px 0;">
            <h2 style="color: #FFD700; margin-bottom: 15px;">🎉 ¡Ganador!</h2>
            <p id="ganador-nombre-especial" class="ganador-nombre" style="font-size: 1.75rem;"></p>
            <p id="ganador-area-especial" class="ganador-area" style="font-size: 1.1rem;"></p>
            <p class="ganador-premio" style="font-size: 1.1rem; color: #8ac9ff;">Premio Especial</p>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
    window.csrfToken = "{{ csrf_token() }}";
</script>
<script src="{{ asset('js/rifa.js?v=' . time()) }}"></script>
@endsection