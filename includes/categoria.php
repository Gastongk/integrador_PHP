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

?>