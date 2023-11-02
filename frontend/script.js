$(document).ready(function() {
    listarNotasPorCategoria(null); 
 
    $("#registroForm").submit(function(event) {
        event.preventDefault(); 

        var username = $("#username").val();
        var password = $("#password").val();
        var email = $("#email").val();

        $.ajax({
            type: "POST",
            url: '../backend/index.php',
            dataType: 'json',
            data: {
                registro: 1,
                username: username,
                password: password,
                email: email
            },
            success: function(response) {
                if (response) {
                    if (response.success) {
      
                        $("#mensajeRegistro").html(response.message);
                    } 
                } else {
           
                    $("#mensajeRegistro").html("No se ejecutó el bloque 'success'");
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log("Error: " + textStatus + " - " + errorThrown);
            }
        });
    });

    $("#loginForm").submit(function(event) {
        event.preventDefault(); 
    
        var username = $("#username_L").val();
        var password = $("#password_L").val();
    
        $.ajax({
            type: "POST",
            url: '../backend/index.php',
            dataType: 'json',
            data: {
                login: 1,
                username: username,
                password: password
            },
            
            success: function(response) {
                console.log(response)
                if (response.success) {
                    // respuesta exitosa al iniciar sesión
                    localStorage.setItem('username', response.data.username);
                    localStorage.setItem('userId', response.data.id);
                 //   window.localStorage.token = response.data.username;
                    console.log(response.data.username)
                    $("#mensajeLogin").html(response.message);
    
            //        $("#nombreUsuario").text(response.data.nombre);

                   setTimeout(function() {
                            window.location.href = "inicio.html";
                }, 2000); // tempo de espera
                } else {
                    $("#mensajeLogin").html("Error: " + response.message);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log("Error: " + textStatus + " - " + errorThrown);
            }
        });
    });
    
    

    const todasOption = $('<li><a class="dropdown-item" href="#">Todas</a></li>');
    todasOption.on('click', function() {
      
        listarNotasPorCategoria(null);
    });
    
    const categoriasMenu = $('#categoriasMenu');
    categoriasMenu.append(todasOption);


    $.ajax({
        url: '../backend/listar_categorias.php',
        method: 'GET',
        dataType: 'json',
        success: function (response) {
            if (response.success) {
   
                const categorias = response.categorias;

                categorias.forEach(function (categoria) {
                       const menuItem = $('<li><a class="dropdown-item" >' + categoria.nombre + '</a></li>');

                    menuItem.on('click', function () {

                        listarNotasPorCategoria(categoria.id);
                    });

                    categoriasMenu.append(menuItem);
                });
            }
        },
        error: function (error) {
            console.error('Error en la solicitud AJAX:', error);
        }
    });

    function listarNotasPorCategoria(categoriaId) {
        var url;
        var requestData;
    
        if (categoriaId) {
            url = '../backend/abm.php?action=listarPorCategoria';

            requestData = {
                accion: 'listarPorCategoria',
                categoriaId: categoriaId
            };
        } else {
            url = '../backend/abm.php?action=listar';
        }
        console.log('categoriaId:', categoriaId);
    
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            data: requestData, // devuelvo requestData como datos 
            success: function (data) {
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
                    $('#tabla-paginas').empty().append('<tr><td colspan="5">No hay páginas para mostrar</td></tr>');
                }
            },
            error: function (error) {
                alert('Error al cargar la lista de páginas.');
            }
        });
    }
    
 });
    
