@extends('layouts.app')

@section('title', 'Cocktails existentes')
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
    }

    .delete-btn {
        color: #F44336;
    }
</style>

@section('content')
<h1>Lista de Cocktails</h1>
<table id="cocktailsTable" class="display responsive nowrap">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Categoría</th>
            <th>Alcohólica</th>
            <th>Vaso</th>
            <th>Ruta Imagen</th>
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
            
            <td>{{ $cocktail->created_at }}</td>
            <td>
                <button class="action-btn edit-btn" onclick="openEditModal({{ $cocktail }})" title="Editar">
                    ✏️
                </button>
                <button class="action-btn delete-btn" onclick="deleteCocktail({{ $cocktail->id }}, this)" title="Eliminar">
                    🗑️
                </button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<!-- Modal de edición -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Editar Cóctel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @csrf
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="categoria" class="form-label">Categoría</label>
                        <input type="text" class="form-control" id="categoria" name="categoria" required>
                    </div>
                    <div class="mb-3">
                        <label for="alcoholica" class="form-label">Alcohólica</label>
                        <select class="form-select" id="alcoholica" name="alcoholica" required>
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="vaso" class="form-label">Vaso</label>
                        <input type="text" class="form-control" id="vaso" name="vaso" required>
                    </div>
                    <div class="mb-3">
                        <label for="ruta_imagen" class="form-label">Ruta Imagen</label>
                        <input type="text" class="form-control" id="ruta_imagen" name="ruta_imagen">
                    </div>
                    <div class="mb-3">
                        <label for="instrucciones" class="form-label">Instrucciones</label>
                        <textarea class="form-control" id="instrucciones" name="instrucciones" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Scripts necesarios -->
<script>
    let cocktailsTable;
    $(document).ready(function() {
        cocktailsTable = $('#cocktailsTable').DataTable({
            responsive: true,
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

        $('#editForm').on('submit', function(e) {
            e.preventDefault();
            const formData = $(this).serialize();
            const actionUrl = `/cocktails/${$('#editForm').data('id')}`;

            $.ajax({
                url: actionUrl,
                type: 'PUT',
                data: formData,
                success: function(response) {
                    Swal.fire({
                        title: 'Mensaje',
                        text: 'El cocktail se actualizó exitosamente',
                        icon: 'success',
                    })

                },
                error: function(error) {
                    console.error('Error al actualizar el cóctel:', error);
                    Swal.fire({
                        title: 'Mensaje',
                        text: 'Ocurrió un error al actualizar el cóctel',
                        icon: 'warning',
                    })
                }
            });
        });
    });

    function openEditModal(cocktail) {
        $('#editForm').data('id', cocktail.id);
        $('#nombre').val(cocktail.nombre);
        $('#categoria').val(cocktail.categoria);
        $('#alcoholica').val(cocktail.alcoholica ? '1' : '0');
        $('#vaso').val(cocktail.vaso);
        $('#ruta_imagen').val(cocktail.ruta_imagen);
        $('#instrucciones').val(cocktail.instrucciones);

        $('#editModal').modal('show');
    }

    function deleteCocktail(id, button) {

        Swal.fire({
            title: '¿Estás seguro?',
            text: "Esta acción no se puede deshacer.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/cocktails/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                }).then(response => {
                    if (!response.ok) {
                        throw new Error('No se pudo eliminar el cóctel.');
                    }

                    Swal.fire({
                        title: 'Mensaje',
                        text: 'El cocktail se eliminó correctamente',
                        icon: 'success',
                    })
                    cocktailsTable.row($(button).closest('tr')).remove().draw();
                }).catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        title: 'Advertencia',
                        text: 'El cocktail no se pudo eliminar.',
                        icon: 'warning',
                    })
                });
            }
        });

    }
</script>
@endsection