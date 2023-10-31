<?php
require_once '../includes/usuario.php';
require_once '../includes/pagina.php';
require_once '../includes/categoria.php';
require_once '../includes/config.php';
header('content-Type: application/json');
session_start();

if (isset($_POST['crear_pagina'])) {
   
    if (isset($_SESSION['usuario']) && $_SESSION['usuario'] instanceof Usuario) {
       
        $titulo = $_POST['titulo'];
        $contenido = $_POST['contenido'];
        $categoriaId = $_POST['categoria_id']; 

     
        $nuevaPagina = Pagina::crearPagina($titulo, $contenido, $categoriaId, $_SESSION['usuario']->getId());

        if ($nuevaPagina instanceof Pagina) {
     
            echo json_encode(["message" => "Página creada con éxito"]);
        } else {
     
            echo json_encode(["error" => "Error al crear la página"]);
        }
    } else {

        echo json_encode(["error" => "Debes iniciar sesión para crear una página"]);
    }
}
?>