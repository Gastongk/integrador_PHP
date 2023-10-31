<?php
require_once 'usuario.php';
require_once 'pagina.php';


$username = 'gaston';
$password = '1111'; // Asegúrate de usar una contraseña segura
$email = 'correo@ejemplo.com';

Usuario::registrarUsuario($username, $password, $email);



// Modificar el retorno de Usuario por un objeto en lugar de un json
  $usuario = Usuario::autenticarUsuario('gaston', '1111'); 
    
if ($usuario) {
    
    $tituloPagina = 'Nuevo Iphone 16';
    $contenidoPagina = 'El nuevo Iphone utlilizaria IA';
    $categoriaId = 4; 

    $resultadoCreacionPagina = Pagina::crearPagina($tituloPagina, $contenidoPagina, $categoriaId, $usuario->getId());

    if ($resultadoCreacionPagina === true) {
        echo "Página creada exitosamente.";
    } else {
        echo "Error al crear la página: " . $resultadoCreacionPagina->getMessage(); 
    }
} else {
    echo "Error al autenticar al usuario.";
}  

?>