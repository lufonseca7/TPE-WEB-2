<?php
require_once './app/controllers/pedidosController.php';
require_once './app/controllers/productosController.php';
require_once './app/controllers/categoriasController.php';

require_once './app/controllers/authController.php';
define('BASE_URL', '//'.$_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['PHP_SELF']).'/');
$action = 'home'; // accion por defecto
if (!empty( $_GET['action'])) {
    $action = $_GET['action'];
}
// parsea la accion para separar accion real de parametros
$params = explode('/', $action);
switch ($params[0]) {
    case 'home':
        $controller = new pedidosController();
        $controller ->showHome();
        break; 
    case 'addPedido':
        $controller = new pedidosController();
        $controller ->addPedido();
        break;
    case 'removePedido':
        $controller = new pedidosController();
        $controller ->removePedido($params[1]);
        break;
    case 'filtrarPedido':
        $controller = new pedidosController();
        $controller->filtrarPedido();
        break; 
    //PRODUCTOS


        case 'products':
            $controller = new productosController();
            $controller->showProducts();
            break;
        case 'addProduct':
            $controller = new productosController();
            $controller->addProduct();
            break;
        case 'removeProducto':
            $controller = new productosController();
            $controller ->removeProducto($params[1]);
            break;
        case 'product':
            $controller = new productosController();
            $controller ->showProduct($params[1]);
            break;
        case 'editProducto':
            $controller = new productosController();
            $controller ->editProduct($params[1]); 
            break;
        case 'actualizarProducto':
            $controller = new productosController();
            $controller ->actualizarProducto($params[1]);
            break;
        case 'filtrarProducto':
            $controller = new productosController();
            $controller ->filtrarProducto();
            break;

        //CATEGORIAS

        case 'categorias':
            $controller = new categoriasController();
            $controller->showCategorias();
            break;
        case 'addCategoria':
            $controller = new categoriasController();
            $controller->addCategoria();
            break;
        case 'removeCategoria':
            $controller = new categoriasController();
            $controller ->removeCategoria($params[1]);
            break;
        case 'editCategoria':
            $controller = new categoriasController();
            $controller ->editCategoria($params[1]); 
            break;
        case 'actualizarCategoria':
            $controller = new categoriasController();
            $controller ->actualizarCategoria($params[1]);
            break;

        
            case 'login':
                $controller = new authController();
                $controller->showLogin(); 
                break;
            case 'auth':
                $controller = new authController();
                $controller->auth();
                break;
            case 'logout':
                $controller = new authController();
                $controller->logout();
                break;
}