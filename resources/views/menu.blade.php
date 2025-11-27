@extends('app')

@section('contenido')
<link href="{{ asset('css/menu.css') }}" rel="stylesheet">

<div class="video-container">
    <video autoplay muted loop id="background-video">
        <source src="{{ asset('background.mp4') }}" type="video/mp4">
        Tu navegador no soporta el formato de video.
    </video>
</div>

<div class="menu-container">
    <h1 class="menu-title">MENÚ PRINCIPAL</h1>
    
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="menu-options">
        <a href="{{ route('rifa') }}" class="menu-button">
            @if($isRaffleStarted)
                Continuar Rifa
            @else
                Iniciar Rifa
            @endif
        </a>
        <a href="{{ route('admin') }}" class="menu-button">Administrar Datos</a>
    </div>
</div>
@endsection
