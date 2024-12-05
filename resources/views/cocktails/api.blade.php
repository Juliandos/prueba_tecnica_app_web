<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Random Cocktails</title>

    <!-- Estilos de DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <style>
        .save-btn {
            background-color: #4CAF50;
            /* Verde */
            border: none;
            color: white;
            padding: 5px 10px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            margin: 2px;
            cursor: pointer;
            border-radius: 4px;
        }
    </style>
</head>

<body>
    <h1>Random Cocktails</h1>
    <table id="cocktailsTable" class="display">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Category</th>
                <th>Alcoholic</th>
                <th>Glass</th>
                <th>Instructions</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cocktails as $cocktail)
                <tr>
                    <td>{{ $cocktail['id'] }}</td>
                    <td>{{ $cocktail['name'] }}</td>
                    <td>{{ $cocktail['category'] }}</td>
                    <td>{{ $cocktail['alcoholic'] }}</td>
                    <td>{{ $cocktail['glass'] }}</td>
                    <td>{{ $cocktail['instructions'] }}</td>
                    <td>
                        <button class="save-btn" onclick="saveCocktail({{ json_encode($cocktail) }})">
                            💾 Save
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
        $(document).ready(function () {
            $('#cocktailsTable').DataTable({
                pageLength: 5,
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

        function saveCocktail(cocktail) {
            // Aquí puedes manejar la lógica para almacenar el cóctel
            console.log('Guardando cóctel:', cocktail);
            alert('El cóctel "' + cocktail.name + '" se ha guardado.');
        }
    </script>
</body>

</html>