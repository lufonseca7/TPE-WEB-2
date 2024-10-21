<?php
require_once './app/models/categoriasModel.php';
require_once './app/views/categoriasView.php';
require_once './app/helpers/authHelper.php';
class categoriasController {
    private $view;
    private $model;
    function __construct() {
        $this->model = new categoriasModel();
        $this->view = new categoriasView();
    }
    function showCategorias() {
        $list = $this->model->getCategorias();
        if(AuthHelper::checkLogin()){
            $this->view->showAdminCategoriasList($list);
        }
        else{
            header('Location: ' . BASE_URL . 'login');
        }
    }

    function addCategoria() {
        AuthHelper::verify();
        // obtengo los datos del usuario
        $nombre = $_POST['nombre'];
        
        
        // validaciones
        if (empty($nombre)) {
            $this->view->showError("Debe completar todos los campos");
            return;
        }
        
        $id_categoria = $this->model->insertCategoria($nombre);
        if ($id_categoria) {
            header('Location: ' . BASE_URL . 'categorias');
        } else {
            $this->view->showError("Error al insertar la categoria");
        }
    }
    
    function removeCategoria($id_categoria){
        AuthHelper::verify();
        $this->model->removeCategoria($id_categoria);
        header('Location: ' . BASE_URL . 'categorias');

    } 

    function editCategoria($id_categoria){
        AuthHelper::verify();
        $categoria = $this->model->showCategoria($id_categoria);
        $this->view->categoriaEdit($id_categoria,$categoria);
    }
   
    function actualizarCategoria($id_categoria){
        AuthHelper::verify();
    $nuevoNombre = $_POST['nombre'];
    $this->model->actualizarCategoria($id_categoria,$nuevoNombre);
    header('Location: ' . BASE_URL .'categorias');
    }
}