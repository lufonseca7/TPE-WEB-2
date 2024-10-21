<?php
require_once './app/models/productoModel.php';
require_once './app/models/categoriasModel.php';

require_once './app/views/productoView.php';
require_once './app/helpers/authHelper.php';
class productosController {
    private $view;
    private $model;
    private $modelCategoria;
    function __construct() {
        $this->model = new productoModel();
        $this->modelCategoria = new categoriasModel();

        $this->view = new productoView();
    }
    function showProducts() {
        $list = $this->model->getProducts();
        $categoria = $this->modelCategoria->getCategorias();
        if(AuthHelper::checkLogin()){
            $this->view->showAdminProductsList($list,$categoria);
        }
        else{
            $this->view->showProductosList($list,$categoria);
        }
    }
    function addProduct(){
        AuthHelper::verify();
            // obtengo los datos del usuario
            $producto = $_POST['producto'];
            $categoria = $_POST['categoria'];
            $precio = $_POST['precio'];
            $marca = $_POST['marca'];
            
            // validaciones
            if (empty($producto) || empty($precio)|| empty($categoria)|| empty($marca)) {
                $this->view->showError("Debe completar todos los campos");
                return;
            }
    
            $idProducto = $this->model->insertProduct($producto, $categoria, $precio,$marca);
            if ($idProducto) {
                header('Location: ' . BASE_URL .'products');
            } else {
                $this->view->showError("Error al insertar el pedido");            
        }  
    }
    function removeProducto($id){
        AuthHelper::verify();
        $this->model->removeProducto($id);
        header('Location: ' . BASE_URL .'products');

    } 
    function filtrarProducto(){
        AuthHelper::init();
        $products= $this->model->getProducts();

        $list = $this->model->filtrarProducto($_POST['filtroCategoria']);
        if(empty($_POST['filtroCategoria'])){
            $this->view->showError("Seleccione una categoria");
            return;
        }
        if(empty($list)){
            $this->view->showError("No existen productos con esta categoria");
            return;
        }
        if(AuthHelper::checkLogin()){
            $this->view->showAdminProductsList($list ,$products);
        }
        else{
            $this->view->showProductosList($list,$products);
        }

    }

    function editProduct($id){
        AuthHelper::verify();
        $categoria = $this->modelCategoria->getCategorias();
        $producto = $this->model->showProducto($id);
        $this->view->productoEdit($id,$producto,$categoria);
    }
   
    function actualizarProducto($id){
        AuthHelper::verify();
    $nuevoNombre = $_POST['nombre'];
    $categoria = $_POST['categoria'];
    $precio = $_POST['precio'];
    $marca = $_POST['marca'];
    if (empty($nuevoNombre) || empty($precio)|| empty($categoria)|| empty($marca)) {
        $this->view->showError("complete todos los campos");
        return;
    }
    $this->model->actualizarProducto($id,$nuevoNombre, $categoria, $precio, $marca);
    header('Location: ' . BASE_URL .'products');
    }

}