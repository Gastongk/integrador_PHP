<?php
require_once 'config.php';

class Categorias {
    public static function listarCategorias() {
        $sql = "SELECT * FROM categorias";
        $categorias = ConexionDB::getInstancia()->obtenerResultados($sql);
        return $categorias;
    }

    public static function listarNotasPorCategoria($categoriaId) {
        $sql = "SELECT * FROM paginas WHERE categoria_id = ?";
        $parametros = [$categoriaId];
        $resultados = ConexionDB::getInstancia()->obtenerResultados($sql, $parametros);
        
        $paginas = [];
        foreach($resultados as $r){
            $pagina = new stdClass;
            $pagina->id = $r['id'];
            $pagina->titulo = $r['titulo'];
            $pagina->contenido = $r['contenido'];
            $pagina->categoriaId = $r['categoria_id'];
            $pagina->usuarioId = $r['usuario_id'];
            $paginas[] = $pagina;
        }
        return $paginas;
    }
}
/* 
// Obtener la lista de categorías
$categorias = Categorias::listarCategorias();

// Mostrar las notas por categoría (reemplaza el ID con el ID de la categoría deseada)
$categoriaId = 2; // Reemplaza con el ID de la categoría que deseas mostrar

$notasPorCategoria = Categorias::listarNotasPorCategoria($categoriaId);

// Imprimir la lista de categorías
echo "Categorías disponibles:<br>";
foreach ($categorias as $categoria) {
    echo "{$categoria['id']} - {$categoria['nombre']}<br>";
}

// Imprimir las notas por categoría
echo "<br>Notas en la categoría seleccionada:<br>";
foreach ($notasPorCategoria as $nota) {
    echo "Título: {$nota['titulo']}<br>";
    echo "Contenido: {$nota['contenido']}<br>";
    echo "<hr>";
} */
?>