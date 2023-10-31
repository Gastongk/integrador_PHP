<?php
require_once '../includes/categoria.php';
header('content-Type: application/json');
session_start();

$response = ['success' => false, 'categorias' => []];

try {
    // Obtiene la lista de categorías desde la base de datos
    $categorias = Categorias::listarCategorias();
    $response['categorias'] = $categorias;
    $response['success'] = true;
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

echo json_encode($response);