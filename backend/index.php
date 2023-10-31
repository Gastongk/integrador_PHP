<?php
require_once '../includes/usuario.php';
require_once '../includes/pagina.php';
require_once '../includes/categoria.php';
require_once '../includes/config.php';
header('content-Type: application/json');
session_start();

if (isset($_POST['registro'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    $resultadoRegistro = Usuario::registrarUsuario($username, $password, $email);
    
    echo ($resultadoRegistro);
}

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    

    $usuarioAutenticado = Usuario::autenticarUsuario($username, $password);

    if ($usuarioAutenticado instanceof Usuario) {
       
        $_SESSION['usuario'] = $usuarioAutenticado; 
        echo ($usuarioAutenticado);
       
 
    } else {
        echo ("$usuarioAutenticado");
    }
}

?>