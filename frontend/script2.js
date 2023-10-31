 $(document).ready(function() {


        var username = localStorage.getItem('username');
        console.log(localStorage)
     //   var username = window.
        if (username) {

            document.getElementById('nombreUsuario').innerHTML = username;
        }
  
        $("#cerrarSesion").click(function() {
            localStorage.removeItem('username');
            $.ajax({
               type: "POST",
               url: "../backend/cerrar_sesion.php", 
               success: function(response) {
                    window.location.href = "index.html";
               },
               error: function(jqXHR, textStatus, errorThrown) {
                   console.log("Error al cerrar sesión: " + textStatus + " - " + errorThrown);
               }
           });
       });

    $('#btnCargar').click(function() {
        const idPagina = $('#id_pagina').val();
        console.log('ID de la Página:', idPagina);
    
        $.ajax({
            url: '../backend/abm.php',
            type: 'POST',
            dataType: 'json',
            data: {
                accion: 'buscarPorId',
                id: idPagina
            },
            success: function(response) {
                if (response.success) {
                    console.log('Página encontrada:', response.pagina);
    
                    $('#titulo').val(response.pagina.titulo);
                    $('#contenido').val(response.pagina.contenido);
                    $('#categoriaId').val(response.pagina.categoriaId);
                    $('#usuarioId').val(response.pagina.usuarioId);
                } else {
                    alert('Página no encontrada.');
                }
            },
            error: function(error) {
                console.error('Error en la solicitud AJAX:', error);
                alert('Error en la solicitud AJAX.');
            }
        });
    });

    $('#btnAgregar').click(function() {
        const titulo = $('#titulo').val();
        const contenido = $('#contenido').val();
        const categoriaId = $('#categoriaId').val();
        const usuarioId = $('#usuarioId').val();

        $.post('../backend/abm.php', { accion: 'agregar', titulo, contenido, categoriaId, usuarioId }, function(response) {
            if (response === true) {
                alert('Página guardada exitosamente.');

                $('#titulo').val('');
                $('#contenido').val('');
                $('#categoriaId').val('');
                $('#usuarioId').val('');
            } else {
                alert('Error al guardar la página.');
            }
        });
    });

    $('#btnEliminar').click(function() {
        const idPagina = $('#id_pagina').val();

       $.ajax({
            url: '../backend/abm.php',
            type: 'POST',
            dataType: 'json',
            data: {
                accion: 'eliminar',
                id: idPagina
            },
            success: function(response) {
                if (response.success) {
                    alert('Página eliminada exitosamente.');
                } else {
                    alert('Error al eliminar la página.');
                }
            },
            error: function(error) {
                alert('Error en la solicitud AJAX.');
            }
        });
    });

    $('#btnCargar').click(function() {
        const idPagina = $('#id_pagina').val();
        console.log('ID de la Página:', idPagina);

        $.ajax({
            url: '../backend/abm.php',
            type: 'POST',
            dataType: 'json',
            data: {
                accion: 'buscarPorId',
                id: idPagina
            },
            success: function(response) {
                if (response.success) {
                    console.log('Página encontrada:', response.pagina);

                    $('#nombre').val(response.pagina.nombre);
                    $('#contenido').val(response.pagina.contenido);
                    $('#categoriaId').val(response.pagina.categoria_id);
                    $('#usuarioId').val(response.pagina.usuario_id);
                } else {
                    alert('Página no encontrada.');
                }
            },
            error: function(error) {
                console.error('Error en la solicitud AJAX:', error);
                alert('Error en la solicitud AJAX.');
            }
        });
    });

    $('#btnActualizar').click(function() {
        const idPagina = $('#id_pagina').val();
        const titulo = $('#titulo').val();
        const contenido = $('#contenido').val();
        const categoriaId = $('#categoriaId').val();
        const usuarioId = $('#usuarioId').val();

        $.ajax({
            url: '../backend/abm.php',
            type: 'POST',
            dataType: 'json',
            data: {
                accion: 'actualizar',
                id: idPagina,
                titulo: titulo,
                contenido: contenido,
                categoriaId: categoriaId,
                usuarioId: usuarioId
            },
            success: function(response) {
                if (response.success) {
                    alert('Página actualizada exitosamente.');
                } else {
                    alert('Error al actualizar la página.');
                }
            },
            error: function(error) {
                alert('Error en la solicitud AJAX.');
            }
        });
    });
});


