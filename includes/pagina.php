<?php
require_once 'usuario.php';
class Pagina {
    private $id;
    private $titulo;
    private $contenido;
    private $categoriaId;
    private $usuarioId;

    public function __construct($id, $titulo, $contenido, $categoriaId, $usuarioId) {
        $this->id = $id;
        $this->titulo = $titulo;
        $this->contenido = $contenido;
        $this->categoriaId = $categoriaId;
        $this->usuarioId = $usuarioId;
    }

    public function getId() {
        return $this->id;
    }

    public function getTitulo() {
        return $this->titulo;
    }

    public function getContenido() {
        return $this->contenido;
    }

    public function getCategoriaId() {
        return $this->categoriaId;
    }

    public function getUsuarioId() {
        return $this->usuarioId;
    }

    
    public static function crearPagina($titulo, $contenido, $categoriaId, $usuarioId) {
       
        $sql = "INSERT INTO paginas (titulo, contenido, categoria_id, usuario_id) VALUES (?, ?, ?, ?)";
        $parametros = [$titulo, $contenido, $categoriaId, $usuarioId];

        try {
            ConexionDB::getInstancia()->ejecutarConsulta($sql, $parametros);
            return true;
        } catch (Exception $e) {
            
            throw new Exception("Error al crear la página: " . $e->getMessage());
        }
    }

    public static function listarPaginas() {
        $conexionDB = ConexionDB::getInstancia();
        
        $sql = "SELECT * FROM paginas";
        $resultados = $conexionDB->obtenerResultados($sql);
        
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
/*     public static function buscarPorId($id) {
        $sql = "SELECT * FROM paginas WHERE id = ?";
        $parametros = [$id];
    
        try {
            $stmt = ConexionDB::getInstancia()->ejecutarConsulta($sql, $parametros);
            $pagina = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($pagina) {
                $paginaObj = new Pagina(
                    $pagina['id'],
                    $pagina['titulo'],
                    $pagina['contenido'],
                    $pagina['categoria_id'],
                    $pagina['usuario_id']
                );
                return $paginaObj;
            } else {
                return null;
            }
        } catch (Exception $e) {
            throw new Exception("Error al buscar la página: " . $e->getMessage());
        }
    } */

    public static function buscarPorId($id) {
        $sql = "SELECT * FROM paginas WHERE id = ?";
        $parametros = [$id];
    
        try {
            $stmt = ConexionDB::getInstancia()->ejecutarConsulta($sql, $parametros);
            $pagina = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($pagina) {
                $paginaObj = new stdClass();
                $paginaObj->id = $pagina['id'];
                $paginaObj->titulo = $pagina['titulo'];
                $paginaObj->contenido = $pagina['contenido'];
                $paginaObj->categoria_id = $pagina['categoria_id'];
                $paginaObj->usuario_id = $pagina['usuario_id'];
                return $paginaObj;
            } else {
                return null;
            }
        } catch (Exception $e) {
            throw new Exception("Error al buscar la página: " . $e->getMessage());
        }
    }
        
    public static function actualizarPagina($id, $titulo, $contenido, $categoriaId, $usuarioId) {
        $sql = "UPDATE paginas SET titulo = ?, contenido = ?, categoria_id = ?, usuario_id = ? WHERE id = ?";
        $parametros = [$titulo, $contenido, $categoriaId, $usuarioId, $id];
    
        try {
            ConexionDB::getInstancia()->ejecutarConsulta($sql, $parametros);
            return true;
        } catch (Exception $e) {
            throw new Exception("Error al actualizar la página: " . $e->getMessage());
        }
    }
    
    public static function eliminarPagina($id) {
        $sql = "DELETE FROM paginas WHERE id = ?";
        $parametros = [$id];
    
        try {
            ConexionDB::getInstancia()->ejecutarConsulta($sql, $parametros);
            return true;
        } catch (Exception $e) {
            throw new Exception("Error al eliminar la página: " . $e->getMessage());
        }
    }
}