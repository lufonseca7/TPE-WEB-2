<?php
class productoView{
    function __construct(){}

    function showAdminProductsList($list,$listCategorias){
        $count = count($list);
        require './templates/productosAdmin.phtml';
    }
    function showProductosList($list,$listCategorias){
        $count = count($list);
        $count = count($listCategorias);
        require './templates/productos.phtml';
    }
    public function showError($error) {
        require './templates/error.phtml';
    }
    function productoEdit($id,$producto,$listCategorias){
        require './templates/editProducto.phtml';
    }
}