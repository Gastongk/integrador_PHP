 $(document).ready(function() {
  
        var username = localStorage.getItem('username');
        var userId = parseInt(localStorage.getItem('userId'));
      //  console.log(localStorage)
        console.log('username:', username);
        console.log('userId:', userId);
     //   var username = window.
       
     
     listarNotasPorUsuario(userId); 
    
    
    function listarNotasPorUsuario(usuarioId) {
        var url = '../backend/abm.php?action=listarPorUsuario'; 
    
        var requestData = {
            accion: 'listarPorUsuario',
            usuarioId: usuarioId
        };
    
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            data: requestData,
            success: function (data) {
        /*         console.log(response); */
                if (data.length > 0) {
                    var tabla = $('#tabla-body');
                    tabla.empty();
    
                    $.each(data, function (index, pagina) {
                        var row = '<tr>' +
                            '<td>' + pagina.id + '</td>' +
                            '<td>' + pagina.titulo + '</td>' +
                            '<td>' + pagina.contenido + '</td>' +
                            '<td>' + pagina.categoriaId + '</td>' +
                            '<td>' + pagina.usuarioId + '</td>' +
                            '</tr>';
                        tabla.append(row);
                    });
                } else {
                    $('#tabla-body').empty().append('<tr><td colspan="5">No hay páginas para mostrar</td></tr>');
                }
            },
            error: function (error) {
                alert('Error al cargar la lista de páginas por usuario.');
            }
        });
    }
     
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



