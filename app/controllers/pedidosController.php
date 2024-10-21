<?php
require_once './app/models/pedidosModel.php';
require_once './app/models/productoModel.php';
require_once './app/views/pedidosView.php';
require_once './app/helpers/authHelper.php';
class pedidosController {
    private $view;
    private $model;
    private $productosModel;
    function __construct() {
        $this->model = new pedidosModel();
        $this->productoModel = new productoModel();
        $this->view = new pedidosView();
    }

    


    function showHome() {
        $list = $this->model->getPedidos();
        $listOfProduct = $this->productoModel->getProducts();
        if(AuthHelper::checkLogin()){
            $this->view->showAdminPedidosList($list,$listOfProduct);
        }
        else{
            $this->view->showPedidosList($list,$listOfProduct);
        }
    }

    function addPedido() {
        AuthHelper::verify();
        // obtengo los datos del usuario
        $id = $_POST['producto'];
        $unidades = $_POST['unidades'];
        
        
        // validaciones
        if (empty($id) || empty($unidades)) {
            $this->view->showError("Debe completar todos los campos");
            return;
        }
        $producto = $this->productoModel->getProduct($id);

        $precio = $producto->precio;

        $monto_total = $precio * $unidades;

        $id_pedido = $this->model->insertPedido($producto->nombre_producto, $producto->marca,$producto->categoria, $producto->precio, $unidades, $monto_total);
        if ($id_pedido) {
            header('Location: ' . BASE_URL);
        } else {
            $this->view->showError("Error al insertar el pedido");
        }
    }
    
    function removePedido($id_pedido){
        AuthHelper::verify();
        $this->model->removePedido($id_pedido);
        header('Location: ' . BASE_URL);

    } 
    function filtrarPedido(){
        AuthHelper::init();
        $products= $this->productoModel->getProducts();

        $list = $this->model->filtrarPedido($_POST['filtroProducto']);
        if(empty($_POST['filtroProducto'])){
            $this->view->showError("Seleccione un producto");
            return;
        }
        if(empty($list)){
            $this->view->showError("No existen compras con este producto");
            return;
        }
        if(AuthHelper::checkLogin()){
            $this->view->showAdminPedidosList($list ,$products);
        }
        else{
            $this->view->showPedidosList($list,$products);
        }

    }

    
   
}