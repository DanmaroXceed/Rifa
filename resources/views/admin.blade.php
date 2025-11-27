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
        <h1 class="menu-title">Administrar Datos</h1>

        <div id="message-container"></div>

        <div class="admin-forms">
            @component('components.form-upload', [
                'id' => 'empleados_csv',
                'route' => 'admin.upload.empleados',
                'label' => 'Cargar Empleados',
            ])
            @endcomponent

            @component('components.form-upload', [
                'id' => 'prizes_csv',
                'route' => 'admin.upload.premios',
                'label' => 'Cargar Premios',
            ])
            @endcomponent

            <form action="{{ route('admin.reset') }}" method="POST" class="upload-form">
                @csrf
                <button type="submit" class="menu-button critical" onclick="return confirm('¿Estás seguro de que deseas reiniciar el sistema? Esta acción eliminará todos los datos.')">
                    Reiniciar Sistema
                </button>
            </form>
        </div>
        <br>
        <a href="{{ route('menu') }}" class="menu-button">Volver al Menú</a>
    </div>

    <script>
        document.querySelectorAll('.file-input').forEach(input => {
            input.addEventListener('change', function() {
                const fileName = this.files[0] ? this.files[0].name : 'Sin archivo seleccionado.';
                const label = this.nextElementSibling;
                const formGroupFile = this.closest('.form-group-file');
                const submitButton = formGroupFile.querySelector('.upload-button');

                label.querySelector('span').textContent = fileName;
                submitButton.style.display = this.files[0] ? 'block' : 'none';
            });
        });

        document.querySelectorAll('.upload-form').forEach(form => {
            form.addEventListener('submit', function(event) {
                event.preventDefault();

                const formData = new FormData(this);
                const messageContainer = document.getElementById('message-container');

                fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content,
                    },
                })
                .then(response => response.json())
                .then(data => {
                    const alertDiv = document.createElement('div');
                    alertDiv.className = `alert ${data.success ? 'alert-success' : 'alert-danger'}`;
                    alertDiv.textContent = data.status;

                    messageContainer.appendChild(alertDiv);

                    setTimeout(() => {
                        alertDiv.style.transition = 'opacity 0.5s ease';
                        alertDiv.style.opacity = '0';
                        setTimeout(() => alertDiv.remove(), 500);
                    }, 5000);
                })
                .catch(error => {
                    console.error('Error:', error);
                    const alertDiv = document.createElement('div');
                    alertDiv.className = 'alert alert-danger';
                    alertDiv.textContent = 'Ocurrió un error inesperado.';
                    messageContainer.appendChild(alertDiv);
                });
            });
        });
    </script>
@endsection