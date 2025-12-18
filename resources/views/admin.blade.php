@extends('app')

@section('contenido')
    <link href="{{ asset('css/menu.css?v=' . time()) }}" rel="stylesheet">
    <div class="video-container">
        <video autoplay muted loop id="background-video">
            <source src="{{ asset('background.mp4') }}" type="video/mp4">
            Tu navegador no soporta el formato de video.
        </video>
    </div>

    <div id="password-modal-overlay" class="password-modal-overlay">
        <div class="password-modal">
            <h2>Confirmar Acción</h2>
            <p id="modal-text-description"></p>
            <input type="password" id="password-input" placeholder="Contraseña...">
            <div id="password-error">Contraseña incorrecta.</div>
            <div class="password-modal-buttons">
                <button id="confirm-reset-button">Confirmar</button>
                <button id="cancel-reset-button">Cancelar</button>
            </div>
        </div>
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

            <form action="{{ route('admin.reset') }}" method="POST" class="upload-form" id="reset-sistema-form">
                @csrf
                <button type="submit" class="menu-button critical">
                    Reiniciar Sistema
                </button>
            </form>

            <form action="{{ route('admin.reset.ganadores') }}" method="POST" class="upload-form" id="reset-ganadores-form">
                @csrf
                <button type="submit" class="menu-button warning">
                    Reiniciar Ganadores
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

        // --- Unified Form and Modal Logic ---
        let formToSubmit = null;
        const passwordModalOverlay = document.getElementById('password-modal-overlay');
        const modalTextDescription = document.getElementById('modal-text-description');
        const confirmResetButton = document.getElementById('confirm-reset-button');
        const cancelResetButton = document.getElementById('cancel-reset-button');
        const passwordInput = document.getElementById('password-input');
        const passwordError = document.getElementById('password-error');

        // Single event listener for all upload forms
        document.querySelectorAll('.upload-form').forEach(form => {
            form.addEventListener('submit', function(event) {
                event.preventDefault();
                const formId = this.id;

                if (formId === 'reset-ganadores-form') {
                    formToSubmit = this;
                    modalTextDescription.textContent = 'Por favor, ingresa la contraseña para reiniciar los ganadores.';
                    openModal();
                } else if (formId === 'reset-sistema-form') {
                    formToSubmit = this;
                    modalTextDescription.textContent = 'Esta acción eliminará todos los datos. Ingresa la contraseña para reiniciar el sistema.';
                    openModal();
                } else {
                    // This handles the file upload forms which are not protected
                    submitForm(this);
                }
            });
        });

        // --- Modal Control Functions ---
        cancelResetButton.addEventListener('click', () => {
            closeModal();
        });

        passwordModalOverlay.addEventListener('click', (event) => {
            if (event.target === passwordModalOverlay) {
                closeModal();
            }
        });

        confirmResetButton.addEventListener('click', () => {
            const hardcodedPassword = '$admin_rifa_2025$'; // IMPORTANT: Change this to a strong, secret password
            const enteredPassword = passwordInput.value;

            if (enteredPassword === hardcodedPassword) {
                if (formToSubmit) {
                    submitForm(formToSubmit);
                }
                closeModal();
            } else {
                passwordError.style.display = 'block';
                passwordInput.value = '';
                passwordInput.focus();
            }
        });

        function openModal() {
            passwordModalOverlay.style.display = 'flex';
            passwordInput.focus();
        }

        function closeModal() {
            passwordModalOverlay.style.display = 'none';
            passwordError.style.display = 'none';
            passwordInput.value = '';
            formToSubmit = null;
        }

        // Generic function to handle form submission via fetch
        function submitForm(formElement) {
            const formData = new FormData(formElement);
            const messageContainer = document.getElementById('message-container');

            fetch(formElement.action, {
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
        }
    </script>
    <style>
        .password-modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            color: white;
        }

        .password-modal {
            background-color: #2c2c2c;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
            text-align: center;
            width: 90%;
            max-width: 400px;
        }

        .password-modal h2 {
            margin-top: 0;
            margin-bottom: 20px;
            color: #fff;
        }

        .password-modal input {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #555;
            background-color: #333;
            color: #fff;
            box-sizing: border-box;
        }

        .password-modal-buttons button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 0 10px;
        }

        #confirm-reset-button {
            background-color: #e74c3c;
            color: white;
        }

        #cancel-reset-button {
            background-color: #7f8c8d;
            color: white;
        }

        #password-error {
            color: #e74c3c;
            margin-top: 10px;
            display: none;
        }
    </style>
@endsection