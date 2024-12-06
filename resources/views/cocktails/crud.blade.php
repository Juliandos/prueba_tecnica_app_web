<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cocktails List</title>

    <!-- Estilos de DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <!-- Estilos para los botones -->
    <style>
        .action-btn {
            border: none;
            background: none;
            cursor: pointer;
            font-size: 18px;
            margin: 0 5px;
        }

        .edit-btn {
            color: #4CAF50;
            /* Verde para editar */
        }

        .delete-btn {
            color: #F44336;
            /* Rojo para eliminar */
        }
    </style>
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
                <th>Acciones</th>
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
                <td>
                    <button class="action-btn edit-btn" onclick="editCocktail({{ $cocktail->id }})" title="Editar">
                        ✏️
                    </button>
                    <button class="action-btn delete-btn" onclick="deleteCocktail({{ $cocktail->id }})" title="Eliminar">
                        🗑️
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Scripts necesarios -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
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

        // Función para manejar la edición de un cóctel
        function editCocktail(id) {
            alert(`Editar cóctel con ID: ${id}`);
            // Redirigir a una ruta para edición
            window.location.href = `/cocktails/${id}/edit`;
        }

        // Función para manejar la eliminación de un cóctel
        function deleteCocktail(id) {
            if (confirm('¿Estás seguro de que deseas eliminar este cóctel?')) {
                fetch(`/cocktails/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('No se pudo eliminar el cóctel.');
                        }
                        alert('Cóctel eliminado exitosamente.');
                        location.reload(); // Recargar la página para actualizar la tabla
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Ocurrió un error al eliminar el cóctel.');
                    });
            }
        }
    </script>
</body>

</html>
