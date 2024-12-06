<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cocktails List</title>

    <!-- Estilos de DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
</head>

<body>
    <h1>Lista de Cocktails</h1>
    <table id="cocktailsTable" class="display">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Alcohólica</th>
                <th>Vaso</th>
                <th>Ruta Imagen</th>
                <th>Instrucciones</th>
                <th>Creado en</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cocktails as $cocktail)
            <tr>
                <td>{{ $cocktail->id }}</td>
                <td>{{ $cocktail->nombre }}</td>
                <td>{{ $cocktail->categoria }}</td>
                <td>{{ $cocktail->alcoholica ? 'Sí' : 'No' }}</td>
                <td>{{ $cocktail->vaso }}</td>
                <td>
                    @if($cocktail->ruta_imagen)
                    <img src="{{ $cocktail->ruta_imagen }}" alt="Imagen de {{ $cocktail->nombre }}" width="50">
                    @else
                    Sin imagen
                    @endif
                </td>
                <td>{{ $cocktail->instrucciones }}</td>
                <td>{{ $cocktail->created_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Scripts necesarios -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#cocktailsTable').DataTable({
                pageLength: 10,
                language: {
                    lengthMenu: "Mostrar _MENU_ registros por página",
                    zeroRecords: "No se encontraron registros",
                    info: "Mostrando página _PAGE_ de _PAGES_",
                    infoEmpty: "No hay registros disponibles",
                    infoFiltered: "(filtrado de _MAX_ registros totales)",
                    search: "Buscar:",
                    paginate: {
                        first: "Primero",
                        last: "Último",
                        next: "Siguiente",
                        previous: "Anterior"
                    }
                }
            });
        });
    </script>
</body>

</html>
