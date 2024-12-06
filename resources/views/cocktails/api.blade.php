@extends('layouts.app')

@section('title', 'Cocktails existentes')

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

@section('content')
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
            <td>{{ $cocktail['nombre'] }}</td>
            <td>{{ $cocktail['categoria'] }}</td>
            <td>{{ $cocktail['alcoholica'] }}</td>
            <td>{{ $cocktail['vaso'] }}</td>
            <td>{{ $cocktail['instrucciones'] }}</td>
            <td>
                <button class="save-btn" onclick="saveCocktail({{ json_encode($cocktail) }}, this)">
                    💾 Save
                </button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<!-- Scripts necesarios -->
<script>
    let cockTailsTable;

    $(document).ready(function() {
        cockTailsTable = $('#cocktailsTable').DataTable({
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

    function saveCocktail(cocktail, button) {
        // Mostrar mensaje en consola
        console.log('Guardando cóctel:', cocktail);

        // Preparar datos para enviar al servidor
        // const cocktailData = {
        //     id: cocktail.id, // ID único del cóctel
        //     nombre: cocktail.nombre,
        //     categoria: cocktail.,
        //     alcoholica: cocktail.alcoholic === "Alcoholic",
        //     vaso: cocktail.glass,
        //     instrucciones: cocktail.instructions,
        //     imagen: cocktail.image || null // Agregar ruta de imagen si existe
        // };

        // Hacer solicitud POST al servidor
        fetch('/cocktails', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    //'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(cocktail)
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error al guardar el cóctel.');
                }
                return response.json();
            })
            .then(data => {
                const rowIndex = cockTailsTable.row($(button).closest('tr')).index();
                cockTailsTable.row(rowIndex).remove().draw();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('No se pudo guardar el cóctel. Intenta de nuevo.');
            });
    }
</script>
@endsection