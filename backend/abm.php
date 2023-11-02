<?php
require_once '../includes/usuario.php';
require_once '../includes/pagina.php';
require_once '../includes/categoria.php';
require_once '../includes/config.php';

header('content-Type: application/json');
session_start();

class ABM {

    public function listar() {
        $paginas = Pagina::listarPaginas(); 
        return $paginas;
    }
    public function listarNotasPorCategoria($categoriaId) {
        $notas = Categorias::listarNotasPorCategoria($categoriaId);
        return $notas;
    }

    public function listarPaginasPorUsuario($usuarioId) {
        // Llama al método en la clase Usuario para obtener las páginas
        $paginas = Usuario::obtenerPaginasPorUsuario($usuarioId);
    
        return $paginas;
    }
    

    public function agregar($titulo, $contenido, $categoriaId, $usuarioId) {
        if (Pagina::crearPagina($titulo, $contenido, $categoriaId, $usuarioId)) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }

    public function buscarPorId($id) {
        $pagina = Pagina::buscarPorId($id);
        if ($pagina) {
            
            return ['success' => true, 'pagina' => $pagina];
        } else {
            return ['success' => false];
        }
    }
/*     public function buscarPorId($id) {
        $pagina = Pagina::buscarPorId($id);
        if ($pagina) {
          
            $paginaData = [
                'id' => $pagina->getId(),
                'titulo' => $pagina->getTitulo(),
                'contenido' => $pagina->getContenido(),
                'categoria_id' => $pagina->getCategoriaId(),
                'usuario_id' => $pagina->getUsuarioId()
            ];
    
            return ['success' => true, 'pagina' => $paginaData];
        } else {
            return ['success' => false];
        }
    } */
    

    public function actualizar($id, $titulo, $contenido, $categoriaId, $usuarioId) {
        if (Pagina::actualizarPagina($id, $titulo, $contenido, $categoriaId, $usuarioId)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
    }

    public function eliminar($id) {
        if (Pagina::eliminarPagina($id)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
    }

    }

$abm = new ABM();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['action']) && $_GET['action'] === 'listar') {
        $paginas = $abm->listar();
        echo json_encode($paginas);
        exit;
    } elseif (isset($_GET['action']) && $_GET['action'] === 'listarPorUsuario') {
        if (isset($_GET['usuarioId'])) {
            $usuarioId = $_GET['usuarioId'];
            $paginas = $abm->listarPaginasPorUsuario($usuarioId);
            echo json_encode($paginas);
            exit;
        }
    }elseif (isset($_GET['action']) && $_GET['action'] === 'listarPorCategoria') {
        if (isset($_GET['categoriaId'])) {
            $categoriaId = $_GET['categoriaId'];
            $notas = $abm->listarNotasPorCategoria($categoriaId);
            echo json_encode($notas);
            exit;
        }
    } 
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['accion'])) {
        $accion = $_POST['accion'];
        if ($accion === 'agregar') {
            if (isset($_POST['titulo'], $_POST['contenido'], $_POST['categoriaId'], $_POST['usuarioId'])) {
                $titulo = $_POST['titulo'];
                $contenido = $_POST['contenido'];
                $categoriaId = $_POST['categoriaId'];
                $usuarioId = $_POST['usuarioId'];
                $abm->agregar($titulo, $contenido, $categoriaId, $usuarioId);
            } else {
                echo 'Faltan datos para agregar la página.';
            }
        } elseif ($accion === 'buscarPorId') {
            $id = $_POST['id'];
            $resultado = $abm->buscarPorId($id);
            echo json_encode($resultado);
            
        } elseif ($accion === 'actualizar') {
            if (isset($_POST['id'], $_POST['titulo'], $_POST['contenido'], $_POST['categoriaId'], $_POST['usuarioId'])) {
                $id = $_POST['id'];
                $titulo = $_POST['titulo'];
                $contenido = $_POST['contenido'];
                $categoriaId = $_POST['categoriaId'];
                $usuarioId = $_POST['usuarioId'];
                $abm->actualizar($id, $titulo, $contenido, $categoriaId, $usuarioId);
            } else {
                echo 'Faltan datos para actualizar la página.';
            }
        } elseif ($accion === 'eliminar') {
            $id = $_POST['id'];
            $abm->eliminar($id);
        } else {
            echo 'Opción no válida.';
        }
    } else {
        echo 'Opción no especificada.';
    }
}
