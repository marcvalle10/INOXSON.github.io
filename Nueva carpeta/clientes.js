$(document).ready(function() {
    $('#clientesTable').DataTable({
        paging: true,
        searching: true,
        ordering: true,
        pageLength: 10,
        lengthMenu: [5, 10, 25, 50, 100],
    });

    // Habilitar edición de celdas
    $('.editable').click(function() {
        var currentElement = $(this);
        var currentValue = currentElement.text();
        var field = currentElement.data('field');
        var row = currentElement.closest('tr');
        var id = row.data('id');

        // Crear un input para editar el valor
        var input = $('<input>', {
            type: 'text',
            value: currentValue,
            blur: function() {
                var newValue = $(this).val();
                // Actualizar el cliente en la base de datos
                $.post('cliente.php', {
                    id: id,
                    field: field,
                    value: newValue,
                    actualizar: true // Indica que se debe actualizar
                }, function(response) {
                    if (response === 'success') {
                        currentElement.text(newValue); // Actualiza el texto de la celda
                    } else {
                        alert('Error al actualizar el cliente.');
                    }
                });
                $(this).remove(); // Remover el input al perder el foco
            },
            keyup: function(e) {
                if (e.which === 13) { // Si se presiona Enter
                    $(this).blur(); // Perder foco para guardar
                }
            }
        });

        currentElement.empty().append(input); // Reemplazar el texto por el input
        input.focus(); // Focalizar el input
    });
});