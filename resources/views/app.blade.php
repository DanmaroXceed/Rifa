<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rifa FGJEZ</title>

    <link rel="shortcut icon" type="image/png" href="{{ asset('/logoweb-1.png') }}">
    <link rel="shortcut icon" sizes="192x192" href="{{ asset('/logoweb-1.png') }}">

    <!-- Vincula la hoja de estilos CSS de Bootstrap 5.2.3 para dar estilos y diseño responsivo -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <!-- Incluye el archivo JavaScript de Bootstrap 5.2.3 con todas las dependencias necesarias en un solo bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>

    <!-- Carga el archivo JavaScript de Bootstrap 5.3.0 con todas las dependencias necesarias (incluyendo Popper.js) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <!-- Vincula la hoja de estilos CSS de Bootstrap 5.3.0 desde una CDN alternativa -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">

    <!-- Carga la librería jQuery versión 3.7.1, que es utilizada por muchas bibliotecas de JavaScript como DataTables -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>

    <!-- Carga el archivo JavaScript de DataTables versión 2.0.5, utilizado para agregar funcionalidad a tablas de datos -->
    <script src="https://cdn.datatables.net/2.0.5/js/dataTables.js"></script>

    <!-- Carga el archivo JavaScript específico de DataTables para integrarse con Bootstrap 5 -->
    <script src="https://cdn.datatables.net/2.0.5/js/dataTables.bootstrap5.js"></script>

    <!-- Vincula la hoja de estilos CSS específica de DataTables para integrarse con Bootstrap 5 -->
    <link href="https://cdn.datatables.net/2.0.5/css/dataTables.bootstrap5.css" rel="stylesheet">

    <!-- Vincula los íconos de Bootstrap Icons versión 1.11.3 para utilizar en el diseño de la página -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
</head>
<body>
    <div>
        @yield('contenido')
    </div>
</body>
</html>